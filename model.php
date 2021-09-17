<?php
include "connect.php";
class model{
    public function all(){
        global $conn; // get the conn variable from outside function
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data; // make the function value equal to $users
    }
    public function single($id){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE id='$id'");
        $stmt->execute();
        $data=$stmt->fetch();
        return $data;
    }

    public function cat($catName){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE catName='$catName'");
        $stmt->execute();
        $data=$stmt->fetch();
        return $data;
    }

    public function whereSingle($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE $where");
        $stmt->execute();
        $data=$stmt->fetch();
        return $data;
    }

    public function where($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE $where");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
    }
    
    public function delete($id){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("DELETE FROM $table WHERE id='$id'");
        $stmt->execute();
    }
    public function insert($columns){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("INSERT INTO $table SET $columns");
        // $columns= userName='$userName' , email= '$email', password= '$passHash'
        $stmt->execute();
    }
    public function update($column,$id){
        global $conn;
        $table=get_class($this);
        $stmt = $conn->prepare("UPDATE $table SET  $column WHERE id='$id' ");
        // $column = userName='$userName', email='$email'
        $stmt->execute();
    }

    // a function checks if a record is duplicate
    public function unique($where){
        global $conn;
        $table = get_class($this);
        $stmt = $conn->prepare("SELECT * FROM $table WHERE $where");
        //$where is a vairable being checked if repeated
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function count(){
        global $conn;
        $table = get_class($this);
        $stmt = $conn->prepare("SELECT * FROM $table");
        //$where is a vairable being checked if repeated
         $stmt->execute();
         $count=$stmt->rowCount();    
        return $count;
    }
}

class users extends model{

}
class categories extends model{

}

class products extends model{ //products class

}

class categorys extends model{ //products class

}

//$uOject = new users;
//
//$uOject->insert("userName='Banda',  email= 'banda@banda.com', password='123123'");



/*
echo '<pre>';
print_r($cObject->all());
echo '</pre>';
*//*
echo '<pre>';
print_r($uObject->single(19));
echo '</pre>';
*/
// $uObject->delete(19);
// $uObject->insert("userName='abdo' , email= 'abdo@gmail.com', password= '123456'");

// $uObject->update("userName='abdo2' , email= 'abdo2@gmail.com', password= '123456'",21);
