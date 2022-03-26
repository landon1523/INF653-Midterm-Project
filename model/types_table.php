<?php
    class TypesTable {

        public static function get_types() {
            $db = Database::getDB();
            $query = "SELECT * FROM types ORDER BY type_id";
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            $types = [];
            foreach($rows as $row) {
                $type = new VehicleType($row['type_id'], $row['type_name']);
                $types[] = $type;
            }

            return $types;
        }

        public static function get_type($type_id) {
            $db = Database::getDB();
            $query = "SELECT * FROM types
                        WHERE type_id = :type_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':type_id', $type_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();

            $type = new VehicleType($row['type_id'] ?? null, $row['type_name'] ?? null);
            return $type;
        }

        public static function add_type($type_name) {
            $db = Database::getDB();
            $count = 0;
            $query = "INSERT INTO types (type_name)
                        VALUES (:type_name)";
            try {
                $statement = $db->prepare($query);
                $statement->bindValue(':type_name', $type_name);
                if ($statement->execute()) {
                    $count = $statement->rowCount();
                }
            } catch (PDOException $e) {
                $count = 0;
            } finally {
                $statement->closeCursor();
            }
            return $count;
        }

        public static function delete_type($type_id) {
            $db = Database::getDB();
            $count = 0;
            $query = "DELETE FROM types
                        WHERE type_id = :type_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':type_id', $type_id);
            if ($statement->execute()) {
                $count = $statement->rowCount();
            }
            $statement->closeCursor();
            return $count;
        }
    }
?>