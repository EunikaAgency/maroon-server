<tr>
    <td colspan="2">
        <div style="
            margin: 1em 0;
            padding: 1em;
            background: #f8f8f8;
            border-left: 4px solid #0073aa;
            font-size: 14px;
            line-height: 1.5;
        ">
            <strong>Tip:</strong> These custom fields are defined in<br>
            <code>wp-content/plugins/category-page-custom-fields/includes/fields.php</code><br><br>
            To add or rename fields, simply edit that file and follow the array structure.<br><br>
            
        </div>
    </td>
</tr>

<?php foreach ($fields as $key => $field): ?>
<tr class="form-field">
    <th scope="row">
        <label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($field['label']); ?></label>
    </th>
    <td>
        <?php
        $value = get_term_meta($term->term_id, $key, true);
        if ($field['type'] === 'wysiwyg') {
            wp_editor($value, $key, [
                'textarea_name' => $key,
                'media_buttons' => false,
                'textarea_rows' => 8,
            ]);
        } elseif ($field['type'] === 'code') {
            ?>
            <textarea class="ccf-code-editor" name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" rows="10" cols="80"><?php echo esc_textarea($value); ?></textarea>
            <?php
        } elseif ($field['type'] === 'textarea') {
            ?>
            <textarea name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" rows="5" cols="50" class="large-text"><?php echo esc_textarea($value); ?></textarea>
            <?php
        } else {
            ?>
            <input type="text" name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>" class="large-text">
            <?php
        }
        
        if (!empty($field['description'])) {
            echo '<p class="description">' . esc_html($field['description']) . '</p>';
        }
        
        if ($field['type'] !== 'meta_title' && $field['type'] !== 'meta_description') {
            echo '<p class="description">Displayed on the category page via shortcode: <code>[category_custom_field key="' . esc_attr($key) . '"]</code></p>';
        }
        ?>
    </td>
</tr>
<?php endforeach; ?>