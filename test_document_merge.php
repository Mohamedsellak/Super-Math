<?php

require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Create a sample question document
echo "Creating sample question document...\n";
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
echo "Question document created at: $questionPath\n";

// Create a sample answer document
echo "Creating sample answer document...\n";
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
echo "Answer document created at: $answerPath\n";

// Now test the merging functionality
echo "Testing document merge...\n";
$mergedDoc = new PhpWord();
$mergedSection = $mergedDoc->addSection();

// Add question section
$mergedSection->addText('QUESTION', ['bold' => true, 'size' => 16]);
$mergedSection->addTextBreak(1);

// Load and copy question content
$loadedQuestionDoc = IOFactory::load($questionPath);
$questionSections = $loadedQuestionDoc->getSections();
foreach ($questionSections as $sourceSection) {
    $elements = $sourceSection->getElements();
    foreach ($elements as $element) {
        if (method_exists($element, 'getText')) {
            $mergedSection->addText($element->getText(), $element->getFontStyle());
        }
    }
}

// Add page break
$mergedSection->addPageBreak();

// Add answer section
$mergedSection->addText('ANSWER', ['bold' => true, 'size' => 16]);
$mergedSection->addTextBreak(1);

// Load and copy answer content
$loadedAnswerDoc = IOFactory::load($answerPath);
$answerSections = $loadedAnswerDoc->getSections();
foreach ($answerSections as $sourceSection) {
    $elements = $sourceSection->getElements();
    foreach ($elements as $element) {
        if (method_exists($element, 'getText')) {
            $mergedSection->addText($element->getText(), $element->getFontStyle());
        }
    }
}

// Save merged document
$mergedPath = storage_path('app/temp/test_merged.docx');
$writer = IOFactory::createWriter($mergedDoc, 'Word2007');
$writer->save($mergedPath);

echo "Merged document created successfully at: $mergedPath\n";
echo "File size: " . number_format(filesize($mergedPath)) . " bytes\n";
echo "Test completed successfully!\n";
