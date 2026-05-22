<?php

require_once __DIR__ . '/../config/koneksi.php';

$APP_LAST_ERROR = '';

function set_app_error($message)
{
    global $APP_LAST_ERROR;
    $APP_LAST_ERROR = trim((string) $message);
}

function get_app_error()
{
    global $APP_LAST_ERROR;
    return $APP_LAST_ERROR;
}

function clear_app_error()
{
    global $APP_LAST_ERROR;
    $APP_LAST_ERROR = '';
}

function db_escape($value)
{
    global $conn;

    return mysqli_real_escape_string($conn, trim((string) $value));
}

function result_or_false($sql)
{
    global $conn;

    clear_app_error();

    if (!$conn) {
        set_app_error('Koneksi database tidak tersedia.');
        return false;
    }

    try {
        $res = mysqli_query($conn, $sql);
        if ($res === false) {
            set_app_error(mysqli_error($conn));
        }
        return $res;
    } catch (mysqli_sql_exception $e) {
        set_app_error($e->getMessage());
        return false;
    }
}

function table_has_column($table, $column, $refresh = false)
{
    static $cache = [];

    $key = $table . '.' . $column;
    if (!$refresh && array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $tableEscaped = db_escape($table);
    $columnEscaped = db_escape($column);
    $sql = "SHOW COLUMNS FROM `$tableEscaped` LIKE '$columnEscaped'";
    $res = result_or_false($sql);
    $exists = $res instanceof mysqli_result && mysqli_num_rows($res) > 0;

    if ($res instanceof mysqli_result) {
        mysqli_free_result($res);
    }

    $cache[$key] = $exists;
    return $exists;
}

function ensure_peminjaman_relation_columns()
{
    if (!table_has_column('peminjaman', 'id_member', true)) {
        result_or_false('ALTER TABLE peminjaman ADD COLUMN id_member INT NULL');
        table_has_column('peminjaman', 'id_member', true);
    }

    if (!table_has_column('peminjaman', 'id_buku', true)) {
        result_or_false('ALTER TABLE peminjaman ADD COLUMN id_buku INT NULL');
        table_has_column('peminjaman', 'id_buku', true);
    }
}

function reset_auto_increment_if_empty($table, $idColumn)
{
    $tableEscaped = db_escape($table);
    $idEscaped = db_escape($idColumn);
    $res = result_or_false("SELECT COUNT(*) AS total FROM `$tableEscaped`");
    if (!($res instanceof mysqli_result)) {
        return;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

    if ((int) ($row['total'] ?? 0) === 0) {
        result_or_false("ALTER TABLE `$tableEscaped` AUTO_INCREMENT = 1");
    }
}

function normalize_year_or_null($year)
{
    $year = trim((string) $year);
    if ($year === '') {
        return null;
    }

    if (!preg_match('/^\\d{4}$/', $year)) {
        return null;
    }

    return $year;
}

function ensure_buku_year_column_int()
{
    $sql = "
        SELECT DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'buku'
          AND COLUMN_NAME = 'tahun_terbit'
        LIMIT 1
    ";

    $res = result_or_false($sql);
    if (!($res instanceof mysqli_result)) {
        return;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    $dataType = strtolower((string) ($row['DATA_TYPE'] ?? ''));

    if ($dataType === 'year') {
        result_or_false('ALTER TABLE buku MODIFY COLUMN tahun_terbit INT(4) NULL');
    }
}

function is_valid_book_year($year)
{
    if (!preg_match('/^\d{4}$/', $year)) {
        return false;
    }

    $yearInt = (int) $year;
    return $yearInt >= 1000 && $yearInt <= 9999;
}

function peminjaman_date_columns()
{
    $pinjam = table_has_column('peminjaman', 'tgl_pinjam') ? 'tgl_pinjam' : 'tanggal_pinjam';
    $kembali = table_has_column('peminjaman', 'tgl_kembali') ? 'tgl_kembali' : 'tanggal_kembali';

    return [$pinjam, $kembali];
}

// Ambil data member
function getMember()
{
    return result_or_false("SELECT * FROM member ORDER BY id_member ASC");
}

// Tambah member
function addMember($nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar)
{
    $nama_member = db_escape($nama_member);
    $nomor_member = db_escape($nomor_member);
    $alamat = db_escape($alamat);
    $tgl_mendaftar = db_escape($tgl_mendaftar);
    $tgl_terakhir_bayar = db_escape($tgl_terakhir_bayar);

    $sql = "
        INSERT INTO member (
            nama_member,
            nomor_member,
            alamat,
            tgl_mendaftar,
            tgl_terakhir_bayar
        ) VALUES (
            '$nama_member',
            '$nomor_member',
            '$alamat',
            '$tgl_mendaftar',
            '$tgl_terakhir_bayar'
        )
    ";

    return result_or_false($sql);
}

// Hapus member
function deleteMember($id_member)
{
    $id_member = (int) $id_member;
    $res = result_or_false("DELETE FROM member WHERE id_member = $id_member");
    if ($res !== false) {
        reset_auto_increment_if_empty('member', 'id_member');
    }

    return $res;
}

// Update member
function updateMember($id_member, $nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar)
{
    $id_member = (int) $id_member;
    $nama_member = db_escape($nama_member);
    $nomor_member = db_escape($nomor_member);
    $alamat = db_escape($alamat);
    $tgl_mendaftar = db_escape($tgl_mendaftar);
    $tgl_terakhir_bayar = db_escape($tgl_terakhir_bayar);

    $sql = "
        UPDATE member
        SET
            nama_member = '$nama_member',
            nomor_member = '$nomor_member',
            alamat = '$alamat',
            tgl_mendaftar = '$tgl_mendaftar',
            tgl_terakhir_bayar = '$tgl_terakhir_bayar'
        WHERE id_member = $id_member
    ";

    return result_or_false($sql);
}

// Ambil data buku
function getBook()
{
    ensure_buku_year_column_int();
    return result_or_false("SELECT * FROM buku ORDER BY id_buku ASC");
}

// Tambah buku
function addBook($judul_buku, $penulis, $penerbit, $tahun_terbit)
{
    ensure_buku_year_column_int();

    $judul_buku = db_escape($judul_buku);
    $penulis = db_escape($penulis);
    $penerbit = db_escape($penerbit);
    $tahun_terbit = trim((string) $tahun_terbit);

    if (!is_valid_book_year($tahun_terbit)) {
        set_app_error('Tahun terbit harus 4 digit antara 1000 sampai 9999.');
        return false;
    }

    $tahunSql = "'" . db_escape($tahun_terbit) . "'";

    $sql = "
        INSERT INTO buku (
            judul_buku,
            penulis,
            penerbit,
            tahun_terbit
        ) VALUES (
            '$judul_buku',
            '$penulis',
            '$penerbit',
            $tahunSql
        )
    ";

    return result_or_false($sql);
}

// Hapus buku
function deleteBook($id_buku)
{
    $id_buku = (int) $id_buku;
    $res = result_or_false("DELETE FROM buku WHERE id_buku = $id_buku");
    if ($res !== false) {
        reset_auto_increment_if_empty('buku', 'id_buku');
    }

    return $res;
}

// Update buku
function updateBook($id_buku, $judul_buku, $penulis, $penerbit, $tahun_terbit)
{
    ensure_buku_year_column_int();

    $id_buku = (int) $id_buku;
    $judul_buku = db_escape($judul_buku);
    $penulis = db_escape($penulis);
    $penerbit = db_escape($penerbit);
    $tahun_terbit = trim((string) $tahun_terbit);

    if (!is_valid_book_year($tahun_terbit)) {
        set_app_error('Tahun terbit harus 4 digit antara 1000 sampai 9999.');
        return false;
    }

    $tahunSql = "'" . db_escape($tahun_terbit) . "'";

    $sql = "
        UPDATE buku
        SET
            judul_buku = '$judul_buku',
            penulis = '$penulis',
            penerbit = '$penerbit',
            tahun_terbit = $tahunSql
        WHERE id_buku = $id_buku
    ";

    return result_or_false($sql);
}

// Ambil data peminjaman
function getPeminjaman()
{
    ensure_peminjaman_relation_columns();
    [$pinjamCol, $kembaliCol] = peminjaman_date_columns();
    $hasMember = table_has_column('peminjaman', 'id_member');
    $hasBook = table_has_column('peminjaman', 'id_buku');

    if ($hasMember && $hasBook) {
        $sql = "SELECT p.*, p.$pinjamCol AS tgl_pinjam, p.$kembaliCol AS tgl_kembali, m.nama_member, b.judul_buku, p.id_member, p.id_buku FROM peminjaman p LEFT JOIN member m ON p.id_member = m.id_member LEFT JOIN buku b ON p.id_buku = b.id_buku ORDER BY p.id_peminjaman DESC";
        $res = result_or_false($sql);
        if ($res !== false) {
            return $res;
        }
    }

    return result_or_false("SELECT p.*, p.$pinjamCol AS tgl_pinjam, p.$kembaliCol AS tgl_kembali, NULL AS nama_member, NULL AS judul_buku FROM peminjaman p ORDER BY p.id_peminjaman DESC");
}

function has_book_loan_overlap($id_buku, $tgl_pinjam, $tgl_kembali, $excludePeminjamanId = null)
{
    ensure_peminjaman_relation_columns();
    [$pinjamCol, $kembaliCol] = peminjaman_date_columns();

    if (!table_has_column('peminjaman', 'id_buku')) {
        return false;
    }

    $id_buku = (int) $id_buku;
    $tgl_pinjam = db_escape($tgl_pinjam);
    $tgl_kembali = db_escape($tgl_kembali);

    $whereExclude = '';
    if ($excludePeminjamanId !== null) {
        $whereExclude = ' AND id_peminjaman <> ' . (int) $excludePeminjamanId;
    }

    $sql = "
        SELECT COUNT(*) AS total
        FROM peminjaman
        WHERE id_buku = $id_buku
          AND NOT ($kembaliCol < '$tgl_pinjam' OR $pinjamCol > '$tgl_kembali')
          $whereExclude
    ";

    $res = result_or_false($sql);
    if (!($res instanceof mysqli_result)) {
        return false;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

    return (int) ($row['total'] ?? 0) > 0;
}

// Tambah peminjaman
function addPeminjaman($tgl_pinjam, $tgl_kembali, $id_member = null, $id_buku = null)
{
    ensure_peminjaman_relation_columns();
    [$pinjamCol, $kembaliCol] = peminjaman_date_columns();
    $hasMember = table_has_column('peminjaman', 'id_member');
    $hasBook = table_has_column('peminjaman', 'id_buku');

    if ($id_member === null || $id_buku === null) {
        set_app_error('Member dan buku wajib dipilih.');
        return false;
    }

    $tgl_pinjam = db_escape($tgl_pinjam);
    $tgl_kembali = db_escape($tgl_kembali);

    if ($tgl_pinjam === '' || $tgl_kembali === '' || $tgl_pinjam > $tgl_kembali) {
        set_app_error('Tanggal peminjaman tidak valid.');
        return false;
    }

    if (has_book_loan_overlap((int) $id_buku, $tgl_pinjam, $tgl_kembali)) {
        set_app_error('Buku sedang dipinjam pada rentang tanggal tersebut. Pilih tanggal lain atau buku lain.');
        return false;
    }

    if ($hasMember && $hasBook && $id_member !== null && $id_buku !== null) {
        $id_member = (int) $id_member;
        $id_buku = (int) $id_buku;

        $sql = "INSERT INTO peminjaman (id_member, id_buku, $pinjamCol, $kembaliCol) VALUES ($id_member, $id_buku, '$tgl_pinjam', '$tgl_kembali')";
        return result_or_false($sql);
    }

    $sql = "INSERT INTO peminjaman ($pinjamCol, $kembaliCol) VALUES ('$tgl_pinjam', '$tgl_kembali')";
    return result_or_false($sql);
}

// Hapus peminjaman
function deletePeminjaman($id_peminjaman)
{
    $id_peminjaman = (int) $id_peminjaman;
    $res = result_or_false("DELETE FROM peminjaman WHERE id_peminjaman = $id_peminjaman");
    if ($res !== false) {
        reset_auto_increment_if_empty('peminjaman', 'id_peminjaman');
    }

    return $res;
}

// Update peminjaman
function updatePeminjaman($id_peminjaman, $tgl_pinjam, $tgl_kembali, $id_member = null, $id_buku = null)
{
    ensure_peminjaman_relation_columns();
    [$pinjamCol, $kembaliCol] = peminjaman_date_columns();
    $hasMember = table_has_column('peminjaman', 'id_member');
    $hasBook = table_has_column('peminjaman', 'id_buku');

    if ($id_member === null || $id_buku === null) {
        set_app_error('Member dan buku wajib dipilih.');
        return false;
    }

    $id_peminjaman = (int) $id_peminjaman;
    $tgl_pinjam = db_escape($tgl_pinjam);
    $tgl_kembali = db_escape($tgl_kembali);

    if ($tgl_pinjam === '' || $tgl_kembali === '' || $tgl_pinjam > $tgl_kembali) {
        set_app_error('Tanggal peminjaman tidak valid.');
        return false;
    }

    if (has_book_loan_overlap((int) $id_buku, $tgl_pinjam, $tgl_kembali, $id_peminjaman)) {
        set_app_error('Buku sedang dipinjam pada rentang tanggal tersebut. Pilih tanggal lain atau buku lain.');
        return false;
    }

    $sets = [];
    $sets[] = "$pinjamCol = '$tgl_pinjam'";
    $sets[] = "$kembaliCol = '$tgl_kembali'";

    if ($hasMember && $id_member !== null) {
        $sets[] = 'id_member = ' . (int) $id_member;
    }
    if ($hasBook && $id_buku !== null) {
        $sets[] = 'id_buku = ' . (int) $id_buku;
    }

    $sql = "UPDATE peminjaman SET " . implode(', ', $sets) . " WHERE id_peminjaman = $id_peminjaman";

    return result_or_false($sql);
}

// Ambil satu peminjaman berdasarkan id
function getPeminjamanById($id_peminjaman)
{
    $id_peminjaman = (int) $id_peminjaman;
    ensure_peminjaman_relation_columns();
    [$pinjamCol, $kembaliCol] = peminjaman_date_columns();
    $hasMember = table_has_column('peminjaman', 'id_member');
    $hasBook = table_has_column('peminjaman', 'id_buku');

    if ($hasMember && $hasBook) {
        $sql = "SELECT p.*, p.$pinjamCol AS tgl_pinjam, p.$kembaliCol AS tgl_kembali, m.nama_member, b.judul_buku, p.id_member, p.id_buku FROM peminjaman p LEFT JOIN member m ON p.id_member = m.id_member LEFT JOIN buku b ON p.id_buku = b.id_buku WHERE p.id_peminjaman = $id_peminjaman LIMIT 1";
        $res = result_or_false($sql);
        if ($res !== false) {
            return $res;
        }
    }

    return result_or_false("SELECT p.*, p.$pinjamCol AS tgl_pinjam, p.$kembaliCol AS tgl_kembali, NULL AS id_member, NULL AS id_buku, NULL AS nama_member, NULL AS judul_buku FROM peminjaman p WHERE p.id_peminjaman = $id_peminjaman LIMIT 1");
}

// Ambil member berdasarkan id
function getMemberById($id_member)
{
    $id_member = (int) $id_member;
    return result_or_false("SELECT * FROM member WHERE id_member = $id_member LIMIT 1");
}

// Ambil buku berdasarkan id
function getBookById($id_buku)
{
    ensure_buku_year_column_int();
    $id_buku = (int) $id_buku;
    return result_or_false("SELECT * FROM buku WHERE id_buku = $id_buku LIMIT 1");
}

?>