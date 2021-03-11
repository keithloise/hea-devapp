<?php

namespace {

    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class JudgesSection extends Section
    {
        private static $singular_name = "Judges Section";

        private static $db = [
            'Year'    => 'Text',
            'Content' => 'HTMLText'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', DropdownField::create('Year', 'Event year',
                EventYear::get()->filter('Archived',false)->map('Name', 'Name'))
            ->setDescription('Please select a year to generate judges.'));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleJudgesBySelectedYear()
        {
            $selectedYear =  date('Y');
            if ($this->owner->Year) {
                $selectedYear = $this->owner->Year;
            }
            $year = EventYear::get()->filter([
                'Archived' => false,
                'Name'     => $selectedYear])->first();

            $categories = CategoryHistory::get()->filter([
                'Archived'  => false,
                'EventYear' => $year->Name]);

            return $categories;
        }
    }
}
