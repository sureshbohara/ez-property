@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => null,
    'cols' => 'col-md-12',
    'rows' => 6,
    'required' => false,
    'options' => [],
    'extraClass' => '',
    'extraId' => '',
    'value' => null,
    'inline' => false,
    'preview' => false,
    'error' => null,
    'accept' => null,
    'disabled' => false,
    'readonly' => false,
    'min' => null,
    'max' => null,
    'step' => null,
    'prompt' => null,
    'editor' => false
])

@php
    $fieldId = $extraId ?: $name;
    $hasError = $error || $errors->has($name);
    $baseClass = 'form-control ' . ($hasError ? 'is-invalid ' : '') . $extraClass;
    $textareaClass = $editor ? $baseClass . ' editor' : $baseClass;
@endphp

<div class="mb-3 {{ $cols }}">
    @if($label)
        <label for="{{ $fieldId }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea name="{{ $name }}"
                  id="{{ $fieldId }}"
                  rows="{{ $rows }}"
                  class="{{ $textareaClass }}"
                  placeholder="{{ $placeholder }}"
                  @if($required) required @endif
                  @if($disabled) disabled @endif
                  @if($readonly) readonly @endif>{{ $value }}</textarea>

    @elseif($type === 'select')
        <select name="{{ $name }}"
                id="{{ $fieldId }}"
                class="{{ $baseClass }}"
                @if($required) required @endif
                @if($disabled) disabled @endif>
            @if($prompt !== null)
                <option value="" disabled {{ $value === '' || $value === null ? 'selected' : '' }}>
                    {{ $prompt }}
                </option>
            @endif
            @foreach($options as $optionValue => $labelOption)
                @if($optionValue !== '' && $optionValue !== null)
                    <option value="{{ $optionValue }}"
                            {{ (string)$value === (string)$optionValue ? 'selected' : '' }}>
                        {{ $labelOption }}
                    </option>
                @endif
            @endforeach
        </select>

    @elseif($type === 'file')
        <input type="file"
               name="{{ $name }}"
               id="{{ $fieldId }}"
               class="{{ $baseClass }}"
               @if($required) required @endif
               @if($disabled) disabled @endif
               @if($preview) onchange="previewImage(this, 'preview-{{ $fieldId }}')" @endif
               accept="{{ $accept ?? '' }}">

        @if($preview)
            @if($value)
                <img src="{{ filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value) }}"
                     id="preview-{{ $fieldId }}"
                     class="mt-2 rounded"
                     style="max-height: 100px; width: auto;">
            @else
                <img src=""
                     id="preview-{{ $fieldId }}"
                     class="mt-2 rounded d-none"
                     style="max-height: 100px; width: auto;">
            @endif
        @endif

    @elseif($type === 'checkbox' || $type === 'radio')
        @foreach($options as $optionValue => $labelOption)
            <div class="form-check {{ $inline ? 'form-check-inline' : '' }}">
                @php
                    $checkName = $type === 'checkbox' && count($options) > 1 ? $name . '[]' : $name;
                    $isChecked = $type === 'checkbox'
                        ? in_array($optionValue, (array) $value)
                        : (string)$value === (string)$optionValue;
                @endphp
                <input type="{{ $type }}"
                       name="{{ $checkName }}"
                       id="{{ $fieldId }}-{{ $optionValue }}"
                       class="form-check-input {{ $hasError ? 'is-invalid' : '' }} {{ $extraClass }}"
                       value="{{ $optionValue }}"
                       @if($isChecked) checked @endif
                       @if($required) required @endif
                       @if($disabled) disabled @endif>
                <label class="form-check-label" for="{{ $fieldId }}-{{ $optionValue }}">
                    {{ $labelOption }}
                </label>
            </div>
        @endforeach

    @elseif($type === 'password')
        <div class="position-relative">
            <input type="password"
                   name="{{ $name }}"
                   id="{{ $fieldId }}"
                   class="{{ $baseClass }}"
                   placeholder="{{ $placeholder }}"
                   @if($required) required @endif
                   @if($disabled) disabled @endif
                   @if($readonly) readonly @endif
                   value="{{ $value }}">
            <span class="password-toggle position-absolute"
                  onclick="togglePassword('{{ $fieldId }}')"
                  style="right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; color: #999;">
                <i class="bi bi-eye-slash" id="eye-{{ $fieldId }}"></i>
            </span>
        </div>

    @else
        <input type="{{ $type }}"
               name="{{ $name }}"
               id="{{ $fieldId }}"
               class="{{ $baseClass }}"
               placeholder="{{ $placeholder }}"
               value="{{ $value }}"
               @if($required) required @endif
               @if($disabled) disabled @endif
               @if($readonly) readonly @endif
               @if($min !== null) min="{{ e($min) }}" @endif
               @if($max !== null) max="{{ e($max) }}" @endif
               @if($step !== null) step="{{ e($step) }}" @endif>
    @endif

    @if($hasError)
        <div class="invalid-feedback d-block">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif
</div>