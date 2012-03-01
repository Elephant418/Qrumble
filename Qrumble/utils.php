<?php


/**************************************************************************
            STRING MANIPULATION
 *************************************************************************/
function startswith( $hay, $needle ) {
  return substr( $hay, 0, strlen( $needle ) ) == $needle;
}
function endswith( $hay, $needle ) {
  return substr( $hay, -strlen( $needle ) ) == $needle;
}
function istartswith( $hay, $needle ) {
  return startswith( strtolower( $hay ), strtolower( $needle ) );
}
function iendswith($hay, $needle) {
  return endswith( strtolower( $hay ), strtolower( $needle ) );
}
function contains($hay, $needle) {
  return ( strpos( $hay, $needle ) !== false );
}
function icontains( $hay, $needle ) {
  return contains( strtolower( $hay ), strtolower( $needle ) );
}

?>