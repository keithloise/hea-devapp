<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

    class AccordionSection extends Section
    {
        private static $singular_name = "Accordion Section";

        private static $db = [
            'Content' => 'HTMLText'
        ];

        private static $has_many = [
            'AccordionItems' => AccordionItem::class,
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $gridConfig = GridFieldConfig_RecordEditor::create(9999);
            if ($this->AccordionItems()->Count()) {
                $gridConfig->addComponent(new GridFieldSortableRows('Sort'));
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }
                ]
            ]);

            $gridField = GridField::create(
                'AccordionItems',
                'Accordion Items',
                $this->AccordionItems(),
                $gridConfig
            );

            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleAccordionItems()
        {
            return $this->AccordionItems()->filter('Archived', false);
        }
    }
}
