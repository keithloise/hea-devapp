<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class GallerySection extends Section
    {
        private static $singular_name = "Gallery Section";

        private static $db = [
            'Content' => 'HTMLText'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleGallery()
        {

        }
    }
}
