<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class TestDocumentMerge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:document-merge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test document merging functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating sample question document...');

        // Create a sample question document
        $questionDoc = new PhpWord();
        $section = $questionDoc->addSection();
        $section->addText('Sample Math Question', ['bold' => true, 'size' => 16]);
        $section->addTextBreak();
        $section->addText('What is the derivative of f(x) = x² + 3x + 2?', ['size' => 12]);
        $section->addTextBreak();
        $section->addText('A) 2x + 3', ['size' => 11]);
        $section->addText('B) x² + 3', ['size' => 11]);
        $section->addText('C) 2x + 2', ['size' => 11]);
        $section->addText('D) x + 3', ['size' => 11]);

        // Save question document
        $questionPath = storage_path('app/temp/test_question.docx');
        if (!file_exists(dirname($questionPath))) {
            mkdir(dirname($questionPath), 0755, true);
        }
        $writer = IOFactory::createWriter($questionDoc, 'Word2007');
        $writer->save($questionPath);
        $this->info("Question document created at: $questionPath");

        // Create a sample answer document
        $this->info('Creating sample answer document...');
        $answerDoc = new PhpWord();
        $section = $answerDoc->addSection();
        $section->addText('Answer Explanation', ['bold' => true, 'size' => 16]);
        $section->addTextBreak();
        $section->addText('The correct answer is A) 2x + 3', ['bold' => true, 'size' => 12]);
        $section->addTextBreak();
        $section->addText('Explanation:', ['bold' => true, 'size' => 11]);
        $section->addText('To find the derivative of f(x) = x² + 3x + 2, we apply the power rule:', ['size' => 11]);
        $section->addText("f'(x) = 2x + 3 + 0 = 2x + 3", ['size' => 11]);

        // Save answer document
        $answerPath = storage_path('app/temp/test_answer.docx');
        $writer = IOFactory::createWriter($answerDoc, 'Word2007');
        $writer->save($answerPath);
        $this->info("Answer document created at: $answerPath");

        // Now test the merging functionality
        $this->info('Testing document merge...');
        $mergedDoc = new PhpWord();
        $mergedSection = $mergedDoc->addSection();

        // Add question section
        $mergedSection->addText('QUESTION', ['bold' => true, 'size' => 16]);
        $mergedSection->addTextBreak(1);

        // Load and copy question content
        $loadedQuestionDoc = IOFactory::load($questionPath);
        $this->copyDocumentContent($loadedQuestionDoc, $mergedSection);

        // Add page break
        $mergedSection->addPageBreak();

        // Add answer section
        $mergedSection->addText('ANSWER', ['bold' => true, 'size' => 16]);
        $mergedSection->addTextBreak(1);

        // Load and copy answer content
        $loadedAnswerDoc = IOFactory::load($answerPath);
        $this->copyDocumentContent($loadedAnswerDoc, $mergedSection);

        // Save merged document
        $mergedPath = storage_path('app/temp/test_merged.docx');
        $writer = IOFactory::createWriter($mergedDoc, 'Word2007');
        $writer->save($mergedPath);

        $this->info("Merged document created successfully at: $mergedPath");
        $this->info("File size: " . number_format(filesize($mergedPath)) . " bytes");
        $this->info('Test completed successfully!');

        return 0;
    }

    /**
     * Copy content from source document to target section
     */
    private function copyDocumentContent($sourceDoc, $targetSection)
    {
        try {
            // Get all sections from source document
            $sections = $sourceDoc->getSections();

            foreach ($sections as $sourceSection) {
                $elements = $sourceSection->getElements();

                foreach ($elements as $element) {
                    $this->copyElement($element, $targetSection);
                }
            }
        } catch (\Exception $e) {
            $this->warn('Direct content copy failed, using fallback method: ' . $e->getMessage());
            $targetSection->addText('Content from original document could not be fully preserved.');
        }
    }

    /**
     * Copy individual elements to target section
     */
    private function copyElement($element, $targetSection)
    {
        $elementClass = get_class($element);

        switch ($elementClass) {
            case 'PhpOffice\PhpWord\Element\Text':
                $targetSection->addText(
                    $element->getText(),
                    $element->getFontStyle(),
                    $element->getParagraphStyle()
                );
                break;

            case 'PhpOffice\PhpWord\Element\TextRun':
                $textRun = $targetSection->addTextRun($element->getParagraphStyle());
                foreach ($element->getElements() as $textElement) {
                    if (method_exists($textElement, 'getText')) {
                        $textRun->addText(
                            $textElement->getText(),
                            $textElement->getFontStyle()
                        );
                    }
                }
                break;

            case 'PhpOffice\PhpWord\Element\TextBreak':
                $targetSection->addTextBreak();
                break;

            default:
                // For unknown elements, try to extract any text content
                if (method_exists($element, 'getText')) {
                    $targetSection->addText($element->getText());
                }
                break;
        }
    }
}
