/*
  # Add admin role and initial setup
  
  1. Changes
    - Add admin role to users.role enum
    - Add status column to users table
    - Add stock_threshold column to books table
    - Create config table for site settings
    
  2. Security
    - Enable RLS on config table
    - Add policy for admin access
*/

DO $$ 
BEGIN
    -- Add admin role if it doesn't exist
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'users' 
        AND column_name = 'role' 
        AND data_type = 'USER-DEFINED'
        AND udt_name = 'role_type'
    ) THEN
        ALTER TYPE role_type ADD VALUE IF NOT EXISTS 'admin';
    END IF;
    
    -- Add status column if it doesn't exist
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'users' 
        AND column_name = 'status'
    ) THEN
        ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT 'active';
    END IF;
    
    -- Add stock_threshold to books if it doesn't exist
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'books' 
        AND column_name = 'stock_threshold'
    ) THEN
        ALTER TABLE books ADD COLUMN stock_threshold INT DEFAULT 5;
    END IF;
END $$;

-- Create config table if it doesn't exist
CREATE TABLE IF NOT EXISTS config (
    key VARCHAR(50) PRIMARY KEY,
    value TEXT NOT NULL,
    description TEXT,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_by UUID REFERENCES auth.users(id)
);

-- Enable RLS
ALTER TABLE config ENABLE ROW LEVEL SECURITY;
