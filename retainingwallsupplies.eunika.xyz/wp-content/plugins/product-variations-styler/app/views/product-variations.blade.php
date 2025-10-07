<script>
    var variations_json = {!! $variations_json !!};
    var default_variation = {!! wp_json_encode($default_attributes) !!};
</script>

<div class="custom-swatches mt-4">


    @foreach ($grouped_variations as $attribute => $values)
        @php
            $attribute_title = str_replace('attribute_', '', $attribute);
            $attribute_title = str_replace('pa_', '', $attribute_title);
        @endphp

        <div id='{{ $attribute }}-buttons' class='specs'>

            <h5 class='bg-light d-flex px-2'>

                @if (isset($title_icons[$attribute]))
                    <img src="<?= $title_icons[$attribute] ?>" class="mr-1">
                @endif

                {{ ucwords($attribute_title) }}
            </h5>

            <div class="attribute-variation-{{$attribute_title}}">

            @foreach ($values as $value)

                @php

                    $image_attachment_id = 0;
                    if( isset( $images[$value]['image']['url']) ){
                        $image_attachment_id = $images[$value]['image_id'];

                    }



                    $active = $default_attributes[$attribute] == $value ? 'default-value' : '';
                @endphp

                <button 
                    image_attachment_id="{{ $image_attachment_id }}" 
                    for='{{ $attribute }}' 
                    data-target="{{ $attribute_title }}" 
                    selector="select[name={{ $attribute }}] option[value='{{ $value }}']"
                    class='btn m-0 {{ $active }} attribute-button {{ $attribute == 'attribute_pa_size' || $attribute == 'attribute_pa_length'  ? 'dimensions' : '' }}
                    {{ $attribute }}-button'  data-attribute='{{ $attribute }}' data-value='{{ $value }}'>

                    @if (isset($images[$value]))
                        <div style='background-image:url({{ $images[$value]['image']['url'] }})' class='variant-img'></div>
                        <span>{{ ucwords( str_replace("-", " ", $value)  ) }}</span>
                    @else
                        @if ($attribute == 'attribute_pa_size')

                            <div class="d-flex align-items-center">
                                <span id="attribute_button_checkbox" style="width: 20px; height: 20px"
                                    class="d-inline rounded mr-3"></span>
                                <span>{!! $sizes_html[$value] !!}</span>
                            </div>

                        @elseif ($attribute == 'attribute_pa_length')

                            <div class="d-flex align-items-center">
                                <span id="attribute_button_checkbox" style="width: 20px; height: 20px"
                                    class="d-inline rounded mr-3"></span>
                                <span>{!! $lengths_html[$value] !!}</span>
                            </div>

                        @else
                            <span>{{ ucwords($value) }}</span>
                        @endif
                    @endif

                </button>
            @endforeach

            </div>




        </div>
    @endforeach
</div>
