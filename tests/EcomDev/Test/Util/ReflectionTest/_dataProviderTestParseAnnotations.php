<?php
return array(
    'a lot of annotations pure doc comment' => array(
        '/**
          *
          *
          * @name value
          * @param value
          * @annotation qwerty qwerty one two three
          * @annotation qwerty qwerty one two three
          * @annotation qwerty qwerty one two three some more text
          */
        ',
        array(
            'name' => array('value'),
            'param' => array('value'),
            'annotation' => array(
                'qwerty qwerty one two three',
                'qwerty qwerty one two three',
                'qwerty qwerty one two three some more text'
            )
        )
    ),
    'a lot of annotation not doc comment' => array(
        '@name value
         @param value
         @annotation qwerty qwerty one two three
         @annotation qwerty qwerty one two three
         @annotation qwerty qwerty one two three some more text
        ',
        array(
            'name' => array('value'),
            'param' => array('value'),
            'annotation' => array(
                'qwerty qwerty one two three',
                'qwerty qwerty one two three',
                'qwerty qwerty one two three some more text'
            )
        )
    ),
    'a lot of annotation with line that does not start with asterix' => array(
        'This @line should not be parsed
         @param value
         @annotation qwerty qwerty one two three
         @annotation qwerty qwerty one two three
         @annotation qwerty qwerty one two three some more text
        ',
        array(
            'param' => array('value'),
            'annotation' => array(
                'qwerty qwerty one two three',
                'qwerty qwerty one two three',
                'qwerty qwerty one two three some more text'
            )
        )
    ),
    'empty doc block' => array(
        '',
        array()
    ),
    'null doc block' => array(
        null,
        array()
    )
);