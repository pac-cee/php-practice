<?php
// Custom PHP Session Handler
class DbSessionHandler implements SessionHandlerInterface {
    private $db;
    public function open($savePath, $sessionName) {
        $this->db = new PDO('sqlite:sessions.db');
        $this->db->exec('CREATE TABLE IF NOT EXISTS sessions (id TEXT PRIMARY KEY, data TEXT, ts INTEGER)');
        return true;
    }
    public function close() { return true; }
    public function read($id) {
        $st = $this->db->prepare('SELECT data FROM sessions WHERE id=?');
        $st->execute([$id]);
        return $st->fetchColumn() ?: '';
    }
    public function write($id, $data) {
        $ts = time();
        $st = $this->db->prepare('REPLACE INTO sessions (id, data, ts) VALUES (?,?,?)');
        return $st->execute([$id, $data, $ts]);
