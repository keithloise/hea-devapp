<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GroupedDropdownField;

    class CategorySection extends Section
    {
        private static $singular_name = "Category Section";

        private static $has_one = [
            'Category' => EventCategory::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', GroupedDropdownField::create('CategoryID', 'Category'));
        }
    }
}
