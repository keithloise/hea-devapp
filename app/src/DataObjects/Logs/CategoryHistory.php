<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\ReadonlyField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;

    class CategoryHistory extends DataObject
    {
        private static $default_sort = 'Sort';

        private static $singular_name = "Category History";
        private static $plural_name = "Category Histories";

        private static $db = [
            'Name'      => 'Text',
            'EventYear' => 'Varchar',
            'Archived'  => 'Boolean',
            'Sort'      => 'Int'
        ];

        private static $has_one = [
            'Category' => EventCategory::class,
        ];

        private static $summary_fields = [
            'Name',
            'EventYear' => 'Event year',
            'Status'
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields(); // TODO: Change the autogenerated stub
            $fields->removeByName('JudgeID');
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('CategoryRO', 'Category', $this->Category()->Name));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Name'));
            $fields->addFieldToTab('Root.Main', TextField::create('EventYear'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }
    }
}
