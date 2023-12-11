<?php

class User {
   
    private $_connect_db;
    public function __construct(){
        $this->_connect_db = new Database;
    }

    public function isVerifyUser($id, $email){
        $this->_connect_db->query(/** @lang text */ 'SELECT a.*, b.* FROM users a inner join records b
        on b.user_id=a.id WHERE a.id =:id AND a.email=:email');
        // Bind the values
        $this->_connect_db->bind(':id', $id);
        $this->_connect_db->bind(':email', $email);
        $row = $this->_connect_db->single();
        if (!empty($row)) {
            return true;
        }else {
            return false;
        }
    }
    
    public function save($data){
        $sql =  $this->_connect_db->query(/** @lang text */"SELECT * FROM `users` ORDER BY id DESC");
        $result= $this->_connect_db->single();
        if(empty($result)){
            $id = '101';
        }else {
            $oldid=$result->id;
            $id = $oldid+1;
        }
        $this->_connect_db->query('INSERT INTO users(id, email, password) VALUES(:id, :email, :password)');
		$this->_connect_db->bind(':id', $id);
        $this->_connect_db->bind(':email', $data['email']);
		$this->_connect_db->bind(':password', $data['password']);
		if($this->_connect_db->execute()){
            $this->_connect_db->query('INSERT INTO records(`user_id`, `name`, `mobile`, `email`, `dob`, `address`, `cv_path`) 
                VALUES(:id, :uname, :mobile, :email, :dob, :ads, :cv)');
		    $this->_connect_db->bind(':id', $id);
            $this->_connect_db->bind(':uname', $data['uname']);
            $this->_connect_db->bind(':email', $data['email']);
            $this->_connect_db->bind(':mobile', $data['mobile']);
            $this->_connect_db->bind(':dob', $data['dob']);
            $this->_connect_db->bind(':ads', $data['ads']);
		    $this->_connect_db->bind(':cv', $data['cv']);
            if($this->_connect_db->execute()){
			    return true;
            }else {
                return false;
            }
		}else {
			return false;
		} 
    }
    
    public function LoginAuth($email, $password){
         
        $this->_connect_db->query(/** @lang text */ 'SELECT a.*, b.* FROM users a INNER JOIN records b ON b.user_id=a.id WHERE a.email =:email');
        // Bind the values
        $this->_connect_db->bind(':email', $email);
        $row = $this->_connect_db->single();
        if(!empty($row)){
            $hashedPassword = $row->password;
            if(password_verify($password, $hashedPassword)){
                return $row;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function CheckExistingUserEmail($email){
        $this->_connect_db->query(/** @lang text */ 'SELECT * FROM users WHERE email =:email');
        // Bind the values
        $this->_connect_db->bind(':email', $email);
		if($this->_connect_db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
    }

    public function get_user($id){
        $this->_connect_db->query(/** @lang text */ 'SELECT a.*, b.* FROM users a INNER JOIN records b ON b.user_id=a.id WHERE a.id =:id');
        // Bind the values
        $this->_connect_db->bind(':id', $id);
        $row = $this->_connect_db->single();
		if(!empty($row)){
			return $row;
		}else{
			return false;
		}
    }

    public function get_all(){
        $this->_connect_db->query(/** @lang text */ 'SELECT a.id, a.email, b.user_id, b.name, b.mobile, b.dob, b.address, b.cv_path FROM users a INNER JOIN records b ON b.user_id=a.id');
        // Bind the values
        $row = $this->_connect_db->fetch_assoc();
		if(!empty($row)){
            $key = [];
            foreach ($row as $rows) {
                // remove user_id because we already have id which have same value as user_id
                unset($rows['user_id']);
                $key[] =$rows;
            }
			return $key;
		}else{
			return false;
		}
    }

    public function updateuserdetailsmodel($id, $name, $email, $mobile, $dob, $ads){
        $this->_connect_db->query(/** @lang text */ 'SELECT a.*, b.* FROM users a INNER JOIN records b ON b.user_id=a.id WHERE a.id =:id');
        // Bind the values
        $this->_connect_db->bind(':id', $id);
        $checkexist = $this->_connect_db->single();
		if(!empty($checkexist)){
            $this->_connect_db->query('UPDATE records SET name=:name, mobile=:mobile, email=:email, dob=:dob, address=:ads WHERE user_id = :id');
            // bind the values
            $this->_connect_db->bind(':id', $id);
            $this->_connect_db->bind(':name', $name);
            $this->_connect_db->bind(':email', $email);
            $this->_connect_db->bind(':dob', $dob);
            $this->_connect_db->bind(':mobile', $mobile);
            $this->_connect_db->bind(':ads', $ads);
            if($this->_connect_db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function changepasswordmodel($data){
        $this->_connect_db->query('SELECT * FROM `users` WHERE id =:id');
		// Bind the values
		$this->_connect_db->bind(':id', $data['id']);
		$row = $this->_connect_db->single();
		if(!empty($row)){
			$hashedPassword = $row->password;
			if(password_verify($data['old'], $hashedPassword)){
				$this->_connect_db->query('UPDATE users SET password = :new WHERE id=:id');
                $this->_connect_db->bind(':id', $data['id']);
				$this->_connect_db->bind(':new', $data['new']);
				if ($this->_connect_db->execute()) {
					return true;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}
    }

    public function deleteUser($id){
        // check if user's exist
        $ids = $id;
        $comma_separated = implode("','", $ids);
        $comma_separated = "'".$comma_separated."'";
		$this->_connect_db->query("SELECT a.*, b.* FROM users a INNER JOIN records b ON b.user_id = a.id WHERE a.id IN (".$comma_separated.") ");
		$checkexist = $this->_connect_db->fetch_assoc();
        if (!empty($checkexist)) {
            // if true user exist then process delete
            $ids = implode("','", $id);
            $this->_connect_db->query("DELETE  a.*, b.* FROM users a INNER JOIN records b ON b.user_id = a.id WHERE a.id IN ('".$ids."')");
            $ids = [];
            if (is_array($ids) || !is_array($ids))
                if ($ids) 
                    foreach ($ids as $k => $id)	
                        $this->_connect_db->bind(($k+1), $id);
                        if($this->_connect_db->execute()){
                            return true;
                        }else{
                            return false;
                        }
        }else {
            // return false to the controller 
            return false;
        }
		
	}
}


