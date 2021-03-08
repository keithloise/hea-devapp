<?php

namespace {

    use SilverStripe\Assets\Image;
    use SilverStripe\Core\ClassInfo;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\Tab;
    use SilverStripe\Forms\TabSet;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;

    class Section extends DataObject
    {
        private static $default_sort  = 'Sort';
        private static $singular_name = 'Content Section';

        private static $db = [
            'Name'     => 'Text',
            'Type'     => 'Text',
            'Content'  => 'HTMLText',
            'Width'    => 'Varchar',
            'Height'   => 'Varchar',
            'Animation'=> 'Text',
            'Archived' => 'Boolean',
            'Sort'     => 'Int',
        ];

        private static $has_one = [
            'Parent' => Page::class,
            'BgImage'=> Image::class,
        ];

        private static $owns = [
            'BgImage',
        ];

        private static $summary_fields = [
            'Name',
            'DisplayType' => 'Section Type',
            'Width',
            'Status'
        ];

        public function getCMSFields()
        {
            $fields = new FieldList();


            $fields->push(Tabset::create('Root', Tab::create('Main')));
            if ($this->Type) {
                $fields->addFieldToTab('Root.Main',
                    $rot = TextField::create('ROType', 'Section type',
                        self::singleton($this->Type)->singular_name()));
                $rot->setDisabled(true);
            } else {
                $fields->addFieldToTab('Root.Main', DropdownField::create("Type", "Section type",
                    $this->getSectionTypes(), $this->ClassName));
            }

            $fields->addFieldToTab('Root.Main', TextField::create('Name'));

            if ($this->Type == 'Section') {
                $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            }

            $instance = self::singleton($this->Type);
            $instance->ID = $this->ID;
            $instance->getSectionCMSFields($fields);

            $fields->addFieldToTab('Root.Settings', DropdownField::create('Width','Section width',
                Width::get()->filter('Archived', false)->map('Name', 'Name')));
            $fields->addFieldToTab('Root.Settings', DropdownField::create('Height', 'Section height',
                array(
                    'none'          => 'None',
                    'large-height'  => 'Large',
                    'medium-height' => 'Medium',
                    'small-height'  => 'Small'
                )));
            $fields->addFieldToTab('Root.Settings', DropdownField::create('Animation','Select animation',
                Animations::get()->filter('Archived', false)->map('Name', 'Name')));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getSectionCMSFields(FieldList $fields)
        {
            return $fields;
        }

        public function onBeforeWrite()
        {
            parent::onBeforeWrite();
            $this->ClassName = $this->Type;
            if($this->Title == ''){
                $this->Title = $this->Type;
            }
        }

        private function getSectionTypes()
        {
            $sectionTypes = array();
            $classes = ClassInfo::getValidSubClasses('Section');
            foreach ($classes as $type) {
                $instance = self::singleton($type);
                $sectionTypes[$instance->ClassName] = $instance->singular_name();
            }
            return $sectionTypes;
        }

        public function getDisplayType()
        {
            return self::singleton($this->Type)->singular_name();
        }

        public function getDisplayTypeTrim()
        {
            $string = str_replace(' ','', self::singleton($this->Type)->singular_name());
            return $string;
        }

        public function Show()
        {
            return $this->renderWith('Layout/Sections/' . $this->ClassName);
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }
    }
}
