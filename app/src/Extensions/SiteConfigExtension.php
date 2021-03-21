<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataExtension;
    use SilverStripe\Versioned\Versioned;

    class SiteConfigExtension extends DataExtension
    {
        private static $db = [
            'PageTheme' => 'Enum(array("dark","light"))',
        ];

        private static $has_one = [
            'SiteLogo'   => File::class,
            'PageBanner' => Image::class,
            'IEPageBanner' => Image::class
        ];

        private static $owns = [
            'SiteLogo',
            'PageBanner',
            'IEPageBanner'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('SiteLogo')
                ->setFolderName('Logo'));
            $fields->addFieldToTab('Root.Main', UploadField::create('PageBanner')
                ->setFolderName('PageBanner'));
            $fields->addFieldToTab('Root.Main', UploadField::create('IEPageBanner', 'For Internet Explorer banner')
                ->setFolderName('PageBanner'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('PageTheme', 'Website theme',
                $this->owner->dbObject('PageTheme')->enumValues()));

            $configYear = GridFieldConfig_RecordEditor::create('999');
            $editorYear = GridField::create('EventYear', 'Event years', EventYear::get(), $configYear);
            $fields->addFieldToTab('Root.EventYear', $editorYear);

            $configAnimation = GridFieldConfig_RecordEditor::create('999');
            $editorAnimation = GridField::create('Animations', 'Animations', Animations::get(), $configAnimation);
            $fields->addFieldToTab('Root.Animation', $editorAnimation);

            $configWidth = GridFieldConfig_RecordEditor::create('999');
            $editorWidth = GridField::create('Width', 'Width', Width::get(), $configWidth);
            $fields->addFieldToTab('Root.SectionWidth', $editorWidth);
        }

        public function onAfterWrite()
        {
            if (!$this->owner->hasExtension(Versioned::class)) {
                $this->owner->publishRecursive();
            }
        }
    }
}
