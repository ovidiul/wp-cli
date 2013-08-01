<?php

namespace WP_CLI;

class DocParser {

	protected $docComment;

	function __construct( $docComment ) {
		$this->docComment = self::remove_decorations( $docComment );
	}

	private static function remove_decorations( $comment ) {
		$comment = preg_replace( '|^/\*\*\n|', '', $comment );
		$comment = preg_replace( '|\n[\t ]*\*/$|', '', $comment );
		$comment = preg_replace( '|^[\t ]*\* ?|m', '', $comment );

		return $comment;
	}

	function get_shortdesc() {
		if ( !preg_match( '|^([^@][^\n]+)\n*|', $this->docComment, $matches ) )
			return false;

		return $matches[1];
	}

	function get_longdesc() {
		return false;
	}

	function get_tag( $name ) {
		if ( preg_match( '|^@' . $name . '\s+([a-z-_]+)|m', $this->docComment, $matches ) )
			return $matches[1];

		return false;
	}

	function get_synopsis() {
		if ( !preg_match( '|^@synopsis\s+(.+)|m', $this->docComment, $matches ) )
			return false;

		return $matches[1];
	}
}

