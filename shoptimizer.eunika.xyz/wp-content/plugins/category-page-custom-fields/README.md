# Category Page Custom Fields

This plugin allows you to define custom fields for WooCommerce product categories and output their values using shortcodes.

---

## 🛠 How It Works

- You define your fields in:  
  `wp-content/plugins/category-page-custom-fields/includes/fields.php`

- Each field can be one of:
  - `wysiwyg` – shows a rich editor
  - `code` – shows a code editor (CodeMirror) for scripts like JSON-LD

- The values can be output using:  
  `[category_custom_field key="your_field_key"]`

---

## ✏️ Adding or Editing Fields

Open `includes/fields.php` and follow this format:

```php
return [
    'custom_html_top' => [
        'label' => 'Custom HTML (Top)',
        'type'  => 'wysiwyg',
    ],
    'custom_schema_jsonld' => [
        'label' => 'JSON-LD Schema Markup',
        'type'  => 'code',
    ],
];
