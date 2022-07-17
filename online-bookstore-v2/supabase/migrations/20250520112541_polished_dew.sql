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
