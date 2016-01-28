<?php

$app->group('/champions', function () {
	//get champions list
	$this->get('', function($req, $res, $args) {
		$sql = "select * FROM champions";
		try {
			$db = getConnection();
			$stmt = $db->query($sql);
			$champions = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			return $res->withStatus(200)->write(json_encode($champions));
		} catch(PDOException $e) {
			return $res->withStatus(400)->write($e->getMessage());
		}
	})->setName('champions');

	//get champion with id
	$this->get('/{id}', function($req, $res, $args){
		$sql = "SELECT * FROM champions WHERE id=".$req->getAttribute('id');
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$champion = $stmt->fetchObject();
			$db = null;
			return $res->withStatus(200)->write(json_encode($champion));
		} catch(PDOException $e) {
			return $res->withStatus(400)->write($e->getMessage());
		}
	});
	// $app->post('/', 'addChampion');
	// $app->put('/:id', 'updateChampion');
	// $app->delete('/:id',	'deleteChampion');
	// $app->get('/search/:query', 'findChampionsByName');
});

function getChampions() {
	$sql = "select * FROM champions";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);
		$champions = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($champions);
	} catch(PDOException $e) {
		echo '{"error":{"text":' . $e->getMessage() . '}}';
	}
}
function getChampion($id) {
	$sql = "SELECT * FROM champions WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$champion = $stmt->fetchObject();
		$db = null;
		echo $champion;
		echo json_encode($champion);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
function addChampion() {
	$request = Slim::getInstance()->request();
	$champion = json_decode($request->getBody());
	$sql = "INSERT INTO champions (name, bans, games, wins) VALUES (:name, :bans, :games, :wins)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $champion->name);
		$stmt->bindParam("bans", $champion->bans);
		$stmt->bindParam("games", $champion->games);
		$stmt->bindParam("wins", $champion->wins);
		$stmt->execute();
		$champion->id = $db->lastInsertId();
		$db = null;
		echo json_encode($champion);
	} catch(PDOException $e) {
		echo '{"error":{"text":' . $e->getMessage() . '}}';
	}
}
function updateChampion($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$champion = json_decode($body);
	$sql = "UPDATE champions SET 'name'=:name, 'bans'=:bans, 'games'=:games, 'wins'=:wins WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $champion->name);
		$stmt->bindParam("bans", $champion->bans);
		$stmt->bindParam("games", $champion->games);
		$stmt->bindParam("wins", $champion->wins);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($champion);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
function deleteChampion($id) {
	$sql = "DELETE FROM champions WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
function findChampionsByName($query) {
	$sql = "SELECT * FROM champions WHERE LOWER(name) LIKE :query ORDER BY name";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$champions = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"champion": ' . json_encode($champions) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}