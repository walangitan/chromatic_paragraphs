<?php

namespace Drupal\chromatic_paragraphs;

use Drupal\file\Entity\File;

/**
 * Custom Preprocessor methods for Chromatic Paragraphs.
 */
class ParagraphsPreprocess {

  /**
   * Implements hook_preprocess_paragraph__foo().
   */
  public function preprocessFoo(array &$variables) {
    $content = $variables['content'];
    $variables['header'] = $content['field_header'][0]['#markup'];
    // {{ header }}
    $variables['text'] = $content['field_body'][0]['#text'];
    // {{ text }}
  }

  /**
   * Implements hook_preprocess_paragraph__bar().
   */
  public function preprocessBar(array &$variables) {
    $content = $variables['content'];
    $field_image = $content['field_image'];
    if (!empty($field_image[0])) {
      $imageId = $field_image['#items'][0]->target_id;
      // Retrieves the File ID.
      $image_file = File::load($imageId);
      // Retrieves the image file form the File ID.
      $imageUri = $image_file->getFileUri();
      // Returns the file URI.
      $imageUrl = $image_file->url();
      // Returns the File URL.
      $variables['content']['imageAlt'] = $field_image['#items'][0]->alt;
      // {{ content.imageAlt }}
      $variables['content']['imageUri'] = $imageUri;
      // {{ content.imageUri }}
      $variables['content']['imageUrl'] = $imageUrl;
      // {{ content.imageUrl }}
    }
    // Return an entity reference
    $nested_entity = !empty($content['field_another_node'][0]['#node']) ? $variables['content']['field_another_node'][0]['#node'] : NULL;
    if ($nested_entity) {
      // Return the field_header value of the entity reference.
      $variables['header'] = $nested_entity->field_header->value;
      // {{ header }}
    }
    $variables['caption'] = $variables['content']['field_caption'][0]['#markup'];
    // {{ caption }}
  }


  /**
   * Implements hook_preprocess_paragraph__block_quote().
   */
  public function preprocessBlockQuote(array &$variables) {
    $content = $variables['content'];
    // field_citation is a link field.
    $variables['citation'] = $content['field_citation'][0]['#url'];
    // {{ citation }}
    $variables['quotation'] = $content['field_quotation'][0]['#markup'];
    // {{ quotation }}
    $variables['byline'] = $content['field_byline'][0]['#markup'];;
    // {{ byline }}
  }
}
