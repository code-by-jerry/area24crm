@props([
    'name',                  // Heroicon name, e.g. 'user', 'arrow-right'
    'variant'  => 'outline', // 'outline' | 'solid'
    'size'     => '24',      // '24' | '20' | '16'
    'class'    => 'w-5 h-5', // Tailwind size + color classes
])

@php
    use App\Helpers\IconHelper;

    // Get the raw SVG
    $svg = IconHelper::svg($name, $variant, $size);

    // Inject class and aria-hidden into the <svg> tag
    // Remove any existing width/height attributes from the source SVG
    $svg = preg_replace('/<svg/', '<svg aria-hidden="true"', $svg, 1);
    $svg = preg_replace('/\s(width|height)="[^"]*"/', '', $svg);

    // Merge the class attribute
    $extraClass = $attributes->get('class', $class);
    $svg = preg_replace('/<svg/', "<svg class=\"{$extraClass}\"", $svg, 1);
@endphp

{!! $svg !!}
