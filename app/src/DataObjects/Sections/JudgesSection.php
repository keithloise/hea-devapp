<?php

namespace {

    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;

    class JudgesSection extends Section
    {
        private static $singular_name = "Judges Section";

        private static $db = [
            'Year' => 'Text'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', DropdownField::create('Year', 'Select year',
                EventYear::get()->filter('Archived',false))
            ->setDescription('Please select a year to generate judges'));
        }

        public function getVisibleJudgesThisYear()
        {
            $selectedYear =  date('Y');
            if ($this->owner->Year) {
                $selectedYear = $this->owner->Year;
            }
            $year = EventYear::get()->filter([
                'Archived' => false,
                'Name'     => $selectedYear])->first();

            $categories = EventCategory::get()->filter([
                'Archived'    => false,
                'EventYearID' => $year->ID]);

            return $categories;
        }
    }
}
