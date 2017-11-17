<?php

class usersAPI
{
		
		protected $pdo;
		
		public function __construct(PDO $pdo)

		{
			$this->pdo = $pdo;
		}


		public function selectAll($extra='')

		{
			$statment = $this->pdo->prepare("SELECT * FROM `users` {$extra}");

			$statment->execute();

			if(!$statment)
				return NULL;



			return $statment->fetchAll(PDO::FETCH_OBJ);
		}

		public function selectByID($id)

		{
			$statment = $this->selectAll("WHERE `id` = {$id}");

			$statment->execute();

			return $statment->fetchAll(PDO::FETCH_OBJ);
		}


		public function update($id,$fname=NULL,$lname=NULL,$email=NULL)
			
		{
				
				$_id = (int)$id;
				$_fname = $this->pdo->quote($fname);
				$_lname = $this->pdo->quote($lname);
				$_email = $this->pdo->quote($email);

				$a = array();
				$q = "UPDATE `clients` SET";
				if(!empty($fname))
					$a[count($a)] = " `firstname` = {$_fname}";
				if(!empty($lname))
					$a[count($a)] = " `lastname` = {$_lname}";
				if(!empty($email))
					$a[count($a)] = " `email` = {$_email}";	
				
				if(count($a) == 1)
				{
					$q = $q . " {$a[0]} WHERE `id` = {$_id}";
					$statment = $this->pdo->prepare($q);
					echo $q;
				}
				else {
					for($i=0;$i<count($a);$i++)

					{

						if($i != count($a)-1)
							$q = $q.$a[$i] . ' , ';

						else
							$q = $q.$a[$i];

					}
					$q  = $q . " WHERE `id` = $_id";
					echo $q;
					$statment = $this->pdo->prepare($q);
				}		

				$e = $statment->execute();

				if(!$e)
					return false;
				return true;
		}	
}