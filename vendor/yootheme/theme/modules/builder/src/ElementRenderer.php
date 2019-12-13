<?php

namespace YOOtheme\Theme;

use YOOtheme\ContainerTrait;
use YOOtheme\Util\Arr;

class ElementRenderer
{
    use ContainerTrait;

    public $inject = [
        'view' => 'app.view',
    ];

    /**
     * Builder renderer callback.
     *
     * @param BuilderElement $element
     * @param Collection     $type
     * @param callable       $next
     *
     * @return string
     */
    public function __invoke($element, $type, $next)
    {
        static $id, $prefix;

        if ($element->prefix) {
            $id = 0; $prefix = $element->prefix;
        }

        // ID
        if ($type['config.element'] || in_array($element->type, ['layout', 'section', 'column', 'row'])) {
            $element->id = $prefix.$id++;
        }

        // Defaults
        if ($defaults = $type['config.defaults']) {
            $element->addProps($defaults);
        }

        // Default props
        if ($props = $type['default.props']) {

            $modified = Arr::some($props, function ($value, $key) use ($element) {
                return isset($element[$key]);
            });

            if (!$modified) {
                $element->addProps($props);
            }
        }

        // Default children
        if ($children = $type['default.children'] and !count($element)) {
            $element->addChildren($children);
        }

        // Class
        $class = (array) $element['class'] ?: [];

        // Attributes
        if (!$element['attrs']) {
            $element['attrs'] = [];
        }

        // Animation
        if (!isset($element['item_animation']) && $element['animation'] != 'none' && $element['animation'] != 'parallax' && $element->parent('section', 'animation') && $element->parent && $element->parent->type == 'column') {
            $element['attrs.uk-scrollspy-class'] = $element['animation'] ? "uk-animation-{$element['animation']}" : true;
        }

        // Parallax
        if ($element['animation'] == 'parallax' || $element['item_animation'] == 'parallax') {

            $options = $this->view->parallaxOptions($element);
            $options[] = is_numeric($element['parallax_easing']) ? "easing: {$element['parallax_easing']}" : '';
            $options[] = $element['parallax_target'] ? 'target: !.uk-section' : '';
            $options[] = is_numeric($element['parallax_viewport']) ? "viewport: {$element['parallax_viewport']}" : '';
            $options[] = $element['parallax_breakpoint'] ? "media: @{$element['parallax_breakpoint']}" : '';
            $element['attrs.uk-parallax'] = implode(';', array_filter($options));

            $class[] = $element['parallax_zindex'] ? 'uk-position-z-index uk-position-relative' : '';
        }

        // Visibility
        if ($visibility = $element['visibility']) {
            $class[] = "uk-visible@{$visibility}";
        }

        // Container Padding Remove
        if ($type['config.element'] && $element['container_padding_remove']) {

            $length = count($element->parent->parent);
            $index = (array_search($element->parent, $element->parent->parent->children) + (bool) $element->parent('row', 'order_last')) % $length;

            $first = $index === 0;
            $last = $index + 1 === $length;

            foreach (['row', 'section'] as $parent) {

                if (!in_array($element->parent($parent, 'width'), ['default', 'small', 'large'])
                    || !$dir = $element->parent($parent, 'width_expand')
                ) {
                    continue;
                }

                $class[] = $first && $dir === 'left'
                    ? 'uk-container-item-padding-remove-left'
                    : ($last && $dir === 'right'
                        ? 'uk-container-item-padding-remove-right'
                        : '');

                break;
            }

        }

        // Margin
        if ($element->type != 'row') {
            switch ($element['margin']) {
                case '':
                    break;
                case 'default':
                    $class[] = 'uk-margin';
                    break;
                default:
                    $class[] = "uk-margin-{$element['margin']}";
            }
        }

        if ($element['margin'] != 'remove-vertical') {
            if ($element['margin_remove_top']) {
                $class[] = 'uk-margin-remove-top';
            }
            if ($element['margin_remove_bottom']) {
                $class[] = 'uk-margin-remove-bottom';
            }
        }

        // Max Width
        if ($maxwidth = $element['maxwidth']) {

            $class[] = $element['maxwidth_breakpoint'] ? "uk-width-{$maxwidth}@{$element['maxwidth_breakpoint']}" : "uk-width-{$maxwidth}";

            switch ($element['maxwidth_align']) {
                case 'right':
                    $class[] = 'uk-margin-auto-left';
                    break;
                case 'center':
                    $class[] = 'uk-margin-auto';
                    break;
            }
        }

        // Text alignment
        if ($element['text_align'] && $element['text_align'] != 'justify' && $element['text_align_breakpoint']) {
            $class[] = "uk-text-{$element['text_align']}@{$element['text_align_breakpoint']}";
            if ($element['text_align_fallback']) {
                $class[] = "uk-text-{$element['text_align_fallback']}";
            }
        } elseif ($element['text_align']) {
            $class[] = "uk-text-{$element['text_align']}";
        }

        // Custom CSS
        if ($element['css']) {

            if (!$element['id']) {
                $element['id'] = $element->id;
            }

            $pre = str_replace('#', '\#', $element['id']);

            $css = $this->theme->get('css', '');
            $css .= self::prefix("{$element['css']}\n", "#{$pre}");

            $this->theme->set('css', $css);
        }

        $element['class'] = $class;

        // demo maps

        $result = $next($element, $type);
        return !in_array($element->type, ['section', 'row', 'column']) || !count($element) || (string) $element ? $result : '';
    }

    /**
     * Prefix CSS selectors.
     *
     * @param string $css
     * @param string $prefix
     *
     * @return string
     */
    protected static function prefix($css, $prefix = '')
    {
        $pattern = '/([@#:\.\w\[\]][\\\\@#:,>~="\'\+\-\.\(\)\w\s\[\]\*]*)({(?:[^{}]+|(?R))*})/s';

        if (preg_match_all($pattern, $css, $matches, PREG_SET_ORDER)) {

            $keys = [];

            foreach ($matches as $match) {

                list($match, $selector, $content) = $match;

                if (in_array($key = sha1($match), $keys)) {
                    continue;
                }

                if ($selector[0] != '@') {
                    $selector = preg_replace('/(^|,)\s*/', "$0{$prefix} ", $selector);
                    $selector = preg_replace('/\s\.el-(element|section|column)/', '', $selector);
                }

                $css = str_replace($match, $selector.self::prefix($content, $prefix), $css); $keys[] = $key;
            }
        }

        return $css;
    }
}
