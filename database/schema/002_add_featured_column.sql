-- Migration: 002_add_featured_column
-- Created: 2026-01-08
-- Purpose: Add is_featured flag to entries for highlighted posts

ALTER TABLE entries ADD COLUMN is_featured TINYINT(1) DEFAULT 0;

-- Index for performance when sorting by featured
CREATE INDEX idx_is_featured ON entries(is_featured);
