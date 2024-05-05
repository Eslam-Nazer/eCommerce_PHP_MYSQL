<?php

/**
 * Get categories record Function V1.0
 */

    function getCats() {
        global $con;

        $stmtCats = $con->prepare('SELECT * FROM categories ORDER BY ID');
        $stmtCats->execute();
        $cats = $stmtCats->fetchAll();

        return $cats;
    }

    /**
     * Function to check the RegStatus of the user
     * check user if Active or Not
     */

    function checkUserStatus($user){
        global $con;

        $stmtx = $con->prepare('SELECT Username, RegStatus FROM users WHERE Username = :user AND RegStatus = 0');
        $stmtx->execute(array(
            'user' => $user
        ));
        $status = $stmtx->rowCount();

        return $status;
    }

/**
 * Get categories record Function V1.1
 */

    function getItems($column,$value) {
    global $con;

    $stmtCats = $con->prepare('SELECT * FROM items WHERE '. $column .' = :value ORDER BY Item_ID');
    $stmtCats->execute(array(
        'value' => $value
    ));
    $items = $stmtCats->fetchAll();

    return $items;
}

/**
 * Title Function That Echo The Page Title In Case The Page (v1.0)
 * Has Variable $pageTitle And Echo Defult Title For Other Pages
 */

    function getTitle() {
        global $pageTitle;
        if(isset($pageTitle)) {
            echo $pageTitle;
        } else {
            echo "Default";
        }
    }

/**
 * [Home, Previous ] Redirect Function [This Function Accept Parameters] (v2.1)
 * $theMsg = Echo The [ Error, Info, Success, etc ] Message
 * $url    = Path That Will Go After Some Action
 * $second = Seconds Before Redirecting / Updated => make second null if null make it by default 3 second else The value found
 */

    function redirectHome($theMsg, $second = null, $url = null) {
        if($url === null) {
            $url    = "index.php";
            $link   = " Home ";
        } else {
            $link   = " Previous ";
        }

        if ($second == null) {
            $second = 3;
        }


        echo $theMsg;
        echo '<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> You Will Redirected To' . $link . 'Page</div>';
        header("refresh:$second;url=$url");
        exit();
    }

/**
 * Check Items Function
 * Function To Check Item In Database [ Function Accept Parameters ]
 * $record = The Item To Select [ Example: user, item, category ]
 * $table  = The Table To Select From [ Example: users, items, categories ]
 * $value  = The Value Of Select [ Example: Osama, Box, Electronics ]
 */

    function checkItems($record, $table, $value) {
        global $con;
        $statement = $con->prepare("SELECT $record FROM $table WHERE $record = :value");
        $statement->execute(array(
            'value' => $value
        ));
        $count = $statement->rowCount();

        return $count;
    }

    /**
     * Count Number Of Items Function V1.0
     * Function To Count Number Of Items Rows
     * $item  = The Item To Count
     * $table = The Table To Choose From
    */

    function countItems($item, $table) {
        global $con;

        $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Get Latest Records Function V1.1
     * Function To Get Latest Items From Database [ Users (Without Admins) , Items , Comments ]
     * $filed = Filed To Select
     * $table = The Table To Choose From
     * $order = The Desc Ordering
     * $limit = Number Of Records To Get
     * $filterIssues = Filtering Data Using Some Options Ex [ All User - Normal Users ]
     */

    function getLatest($filed, $table, $order, $limit, $filterIssues = null) {
        global $con;
        $filterQuery = null;

        if ($filterIssues == 'user') {
            $filterQuery = 'WHERE GroupID != 1'; // Using In Filter Data And Get Normal users (Not Admin)
        }


        $stmt = $con->prepare("SELECT $filed FROM $table $filterQuery ORDER BY $order DESC LIMIT $limit ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return $rows;
    }