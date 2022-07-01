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

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    /**
     * Indicates whether the user has admin privileges.
     */
    public function isAdmin(): bool {
        return false;
    }
