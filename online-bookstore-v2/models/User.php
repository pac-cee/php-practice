<?php
// File: models/User.php

class User {
    protected int $id;
    protected string $username;
    protected string $email;
    protected string $createdAt;

    public function __construct(int $id, string $username, string $email, string $createdAt) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    public function getId(): int {
        return $this->id;
    }
