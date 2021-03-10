<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\LabelField;

    class FinalistsSection extends Section
    {
        private static $singular_name = "Finalists Section";

        private static $db = [
            'Content' => 'HTMLText',
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleEventFinalists()
        {
            return $this->EventFinalists()->filter('Archived', false);
        }
    }
}
