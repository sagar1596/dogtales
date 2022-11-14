<?php

namespace Drupal\ckeditor_readmore\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Google Search" plugin.
 *
 * @CKEditorPlugin(
 *   id = "readmore",
 *   label = @Translation("Read more button"),
 *   module = "ckeditor_readmore"
 * )
 */
class ReadMore extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface
{

  /**
   * Returns the buttons that this plugin provides, along with metadata.
   *
   * The metadata is used by the CKEditor module to generate a visual CKEditor
   * toolbar builder UI.
   *
   * @return array
   *   An array of buttons that are provided by this plugin. This will
   *   only be used in the administrative section for assembling the toolbar.
   *   Each button should be keyed by its CKEditor button name (you can look up
   *   the button name up in the plugin.js file), and should contain an array of
   *   button properties, including:
   *   - label: A human-readable, translated button name.
   *   - image: An image for the button to be used in the toolbar.
   *   - image_rtl: If the image needs to have a right-to-left version, specify
   *     an alternative file that will be used in RTL editors.
   *   - image_alternative: If this button does not render as an image, specify
   *     an HTML string representing the contents of this button.
   *   - image_alternative_rtl: Similar to image_alternative, but a
   *     right-to-left version.
   *   - attributes: An array of HTML attributes which should be added to this
   *     button when rendering the button in the administrative section for
   *     assembling the toolbar.
   *   - multiple: Boolean value indicating if this button may be added multiple
   *     times to the toolbar. This typically is only applicable for dividers
   *     and group indicators.
   */
  public function getButtons()
  {
    return [
      'btn_readmore' => [
        'label' => $this->t('Read more'),
        'image' => drupal_get_path('module','ckeditor_readmore') . '/src/readmore/icons/readmore.png',
      ],
    ];
  }

  /**
   * Returns the Drupal root-relative file path to the plugin JavaScript file.
   *
   * Note: this does not use a Drupal library because this uses CKEditor's API,
   * see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.resourceManager.html#addExternal.
   *
   * @return string|false
   *   The Drupal root-relative path to the file, FALSE if an internal plugin.
   */
  public function getFile()
  {
    return drupal_get_path('module','ckeditor_readmore') . '/src/readmore/plugin.js';
  }

  /**
   * Returns the additions to CKEDITOR.config for a specific CKEditor instance.
   *
   * The editor's settings can be retrieved via $editor->getSettings(), but be
   * aware that it may not yet contain plugin-specific settings, because the
   * user may not yet have configured the form.
   * If there are plugin-specific settings (verify with isset()), they can be
   * found at
   * @code
   * $settings = $editor->getSettings();
   * $plugin_specific_settings = $settings['plugins'][$plugin_id];
   * @endcode
   *
   * @param \Drupal\editor\Entity\Editor $editor
   *   A configured text editor object.
   * @return array
   *   A keyed array, whose keys will end up as keys under CKEDITOR.config.
   */
  public function getConfig(Editor $editor)
  {
    $settings = $editor->getSettings();

    $config = [];

    if (isset($settings['plugins']['readmore'])) {
      $config['readmore_type'] = $settings['plugins']['readmore']['type'];
      $config['readmore_more_text'] = $settings['plugins']['readmore']['more_text'];
      $config['readmore_less_text'] = $settings['plugins']['readmore']['less_text'];
    }

    return $config;
  }

  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor)
  {
    $settings = $editor->getSettings();
    //dd($settings);
    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Type of read more element'),
      '#description' => $this->t('Choose between plain text and button'),
      '#required' => true,
      '#options' => [
        'text' => $this->t('Plain text'),
        'button' => $this->t('Button')
      ],
      '#default_value' => isset($settings['plugins']['readmore']['type'])
        ? $settings['plugins']['readmore']['type'] : 'text',
    ];

    $form['more_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text in read more element'),
      '#description' => $this->t('This text shows up in read more element'),
      '#required' => true,
      '#size' => 60,
      '#maxlength' => 128,
      '#default_value' => isset($settings['plugins']['readmore']['more_text'])
        ? $settings['plugins']['readmore']['more_text'] : $this->t('Read more')
    ];
    $form['less_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text in show less element'),
      '#description' => $this->t('This text shows up in show less element'),
      '#required' => true,
      '#size' => 60,
      '#maxlength' => 128,
      '#default_value' => isset($settings['plugins']['readmore']['less_text'])
        ? $settings['plugins']['readmore']['less_text'] :  $this->t('Show less')
    ];

    return $form;
  }
}
