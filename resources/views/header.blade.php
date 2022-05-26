<!DOCTYPE html>
<html {!! get_language_attributes() !!}>
  <head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('partials/favicons')
    @php wp_head() @endphp
  </head>
  <body @php body_class() @endphp>
