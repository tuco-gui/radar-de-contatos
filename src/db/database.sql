CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user INTEGER NOT NULL UNIQUE,
  admin INTEGER NOT NULL DEFAULT 0,
  banned INTEGER NOT NULL DEFAULT 0,
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS person_records (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  full_name TEXT NOT NULL,
  birth_date TEXT,
  mother_name TEXT,
  father_name TEXT,
  city TEXT,
  state TEXT,
  source TEXT NOT NULL,
  source_reference TEXT,
  purpose TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_person_records_name ON person_records(full_name);
CREATE INDEX IF NOT EXISTS idx_person_records_city ON person_records(city);
CREATE INDEX IF NOT EXISTS idx_person_records_birth_date ON person_records(birth_date);
