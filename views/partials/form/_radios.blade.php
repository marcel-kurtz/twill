@php
    $note = $note ?? false;
    $options = method_exists($options, 'map') ? $options->map(function($label, $value) {
        return [
            'value' => $value,
            'label' => $label
        ];
    })->values()->toArray() : $options;

    $placeholder = $placeholder ?? false;
    $required = $required ?? false;
    $default = $default ?? false;
    $inline = $inline ?? false;

    $addNew = $addNew ?? false;
    $moduleName = $moduleName ?? null;
    $storeUrl = $storeUrl ?? '';
    $inModal = $fieldsInModal ?? false;
@endphp

<a17-singleselect
    label="{{ $label }}"
    @include('cms-toolkit::partials.form.utils._field_name')
    :options="{{ json_encode($options) }}"
    @if ($default) selected="{{ $default }}" @endif
    :grid="false"
    @if ($inline) :inline="true" @endif
    @if ($required) :required="true" @endif
    @if ($inModal) :in-modal="true" @endif
    @if ($addNew) add-new='{{ $storeUrl }}' @elseif ($note) note='{{ $note }}' @endif
    :has-default-store="true"
    in-store="value"
>
@if($addNew)
    <div slot="addModal">
        @partialView(($moduleName ?? null), 'create', ['renderForModal' => true, 'fieldsInModal' => true])
    </div>
@endif
</a17-singleselect>

@unless($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))
@push('vuexStore')
    window.STORE.form.fields.push({
        name: '{{ $name }}',
        value: @if(isset($item) && is_numeric($item->$name)) {{ $item->$name }} @else {!! json_encode($item->$name ?? $formFieldsValue) !!} @endif
    })
@endpush
@endunless
