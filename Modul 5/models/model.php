<?php 

require_once __DIR__ . '../config/koneksi.php';

$APP_LAST_ERROR = ' ';

function set_app_error($massage){
    global $APP_LAST_ERROR;
    $APP_LAST_ERROR =trim((string) $massage);
}

function get_app_error(){
    global $APP_LAST_ERROR;
    return $APP_LAST_ERROR;
}

function clear_app_error(){
    global $APP_LAST_ERROR;
    $APP_LAST_ERROR = ' ';
}

function db_escape($value){
    global $conn;
    return mysqli_real_escape_string($conn, trim((string) $value));
}

function result_or_false($sql){
    global $conn;

    clear_app_error();

    if(!$conn){
        set_app_error('Koneksi database tidak tersedia');
        return false;
    } 
    
    try {
        $res = mysqli_query($conn, $sql);
        if ($res === false) {
            set_app_error (mysqli_error($conn));
        }
        return $res;
    } catch (mysqli_sql_exception $e) {
        set_app_error($e->getMessage());
        return false;
    }
}

function table_has_column($table, $column, $refresh = false){
    static $cache = [];

    $key = $table . '.' . $column;
    if (!$refresh && array_key_exists($key, $cache)){
        return $cache[$key];
    }

    $tableEscaped = db_escape($table);
    $columnEscaped = db_escape($column);
    $sql = "SHOW COLUMNS FROM '$tableEscaped' LIKE '$columnEscaped'";
    $res = result_or_false($sql);
    $exists = $res instanceof mysqli_result && mysqli_num_rows($res) > 0;

    if ($res instanceof mysqli_result){
        mysqli_free_result($res);
    }

    $cache[$key] = $exists;
    return $exists;
}

function ensure_peminjaman_columns(){
    if (!table_has_column('peminjaman', 'id_member', true)){
        result_or_false('ALTER TABLE peminjaman ADD COLUMN id_member INT NULL');
        table_has_column('peminjaman', 'id_member', true);
    } 
    if (!table_has_column('peminjaman', 'id_buku', true)){
        result_or_false('ALTER TABLE peminjaman ADD COLUMN id_buku INT NULL');
        table_has_column('peminjaman', 'id_buku', true);
    }
}

function reset_auto_inrement_if_empty($table, $idColumn){
    $tableEscaped = db_escape($table);
    $idEscaped = db_escape($idColumn);
    $res = result_or_false("SELECT COUNT(*) AS total FROM '$tableEscaped'");
    if (!($res instanceof mysqli_result)){
        return;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

    if ((int) ($row['total'] ?? 0) === 0){
        result_or_false("ALTER TABLE '$tableEscaped' AUTO_INCREMENT = 1' ");
    }
}

function normalize_year_or_null($value){
    $year = trim((string) $year);
    if ($year === ' '){
        return null;
    }

    if (!preg_match('/^\\d{4}$/', $year)){
        return null;
    }

    return $year;
}

function ensure_buku_year_column_int(){
    $sql = "
        SELECT DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'buku'
            AND COLUMN_NAME = 'tahun_terbit'
        LIMIT 1
    ";

    $res = result_or_false($sql);
    if (!($res instanceof mysqli_result)){
        return;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    $dataType = strtolower((string) ($row['DATA_TYPE'] ?? ''));

    if ($dataType === 'year'){
        result_or_false('ALTER TABLE buku MODIFY COLUMN tahun_terbit INT(4) NULL');
    }
}

function is_valid_book_year($year){
    if (!preg_match('/^\\d{4}$/', $year)){
        return false;
    }

    $yearInt = (int) $year;
    return $yearInt >= 1000 && $yearInt <= 9999;
}

?>