<?php
/**
 * @copyright Copyright (C) 2011-2013 Michael De Wildt. All rights reserved.
 * @author Michael De Wildt (http://www.mikeyd.com.au/)
 * @license This program is free software; you can redistribute it and/or modify
 *          it under the terms of the GNU General Public License as published by
 *          the Free Software Foundation; either version 2 of the License, or
 *          (at your option) any later version.
 *
 *          This program is distributed in the hope that it will be useful,
 *          but WITHOUT ANY WARRANTY; without even the implied warranty of
 *          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *          GNU General Public License for more details.
 *
 *          You should have received a copy of the GNU General Public License
 *          along with this program; if not, write to the Free Software
 *          Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA.
 */
class WPB2D_Database_Plugins extends WPB2D_Database_Base
{
    public function __construct()
    {
        parent::__construct('plugins');
    }

    public function execute()
    {
        if ($this->exists())
            return false;

        $this->write_db_dump_header();

        $tables = $this->database->get_results('SHOW TABLES', ARRAY_N);
        $core_tables = array_values($this->database->tables());
        $tables_to_backup = array();

        foreach ($tables as $t) {
            $table = $t[0];
            if (!in_array($table, $core_tables))
                $tables_to_backup[] = $table;
        }

        if (!empty($tables_to_backup))
            $this->backup_database_tables($tables_to_backup);

        return $this->close_file();
    }
}
