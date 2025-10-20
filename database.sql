-- Database schema for NoteIt application
-- This file contains the SQL statements to create the database and tables

-- Create database (uncomment if you need to create the database)
-- CREATE DATABASE IF NOT EXISTS `noteit` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `noteit`;

-- Create notes table
CREATE TABLE IF NOT EXISTS `notes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL DEFAULT '',
    `content` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Insert some sample data
INSERT INTO `notes` (`title`, `content`) VALUES
('Welcome to NoteIt', 'This is your first note. You can edit or delete it anytime.'),
('Getting Started', 'Use the form above to create new notes. Each note has a title and content.'),
('Features', 'You can create, read, update, and delete notes. All changes are saved automatically.');

-- Optional: Create indexes for better performance
CREATE INDEX `idx_notes_created_at` ON `notes` (`created_at`);
CREATE INDEX `idx_notes_updated_at` ON `notes` (`updated_at`);
