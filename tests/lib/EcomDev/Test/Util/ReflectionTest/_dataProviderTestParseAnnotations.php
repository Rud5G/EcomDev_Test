<?php
/**
 * Test Framework for Magento for Integration with various test solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev_Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

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