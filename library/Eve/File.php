<?php
	class Eve_File {

		/**
		 *	Move file
		 * @param string $from
		 * @param string $to
		 * @return bool
		 */
		public static function move($from, $to) {
			if (file_exists($from)) {
				copy($from, $to);
				return self::unlink($from);
			} else {
				return false;
			}
		}

		/**
		 *	Alias for Eve_File::move()
		 * @param string $from
		 * @param string $to
		 * @return bool
		 */
		public function rename($from, $to) {
			self::move($from, $to);
		}

		/**
		 *	Permanently delete the file
		 * @param string $file
		 */
		public static function unlink($file) {
			if (file_exists($file)) {
				unlink($file);
			}
		}

		public function makeName($file) {
			$name = basename($file);
			$splitted = explode('.', $file);
			$ext = array_pop($splitted);

			$newName = md5(time().rand(1000, 9999));

			$newName = substr($newName, 1, 8);

			return $newName.'.'.$ext;
		}

	}