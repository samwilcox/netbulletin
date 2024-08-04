<?php

/**
 * NET BULLETIN
 * 
 * By Sam Wilcox <sam@netbulletin.net>
 * https://www.netbulletin.net
 * 
 * This software is released under the MIT license.
 * To view more details, visit:
 * https://license.netbulletin.net
 */

 namespace NetBulletin\Middleware;

 use NetBulletin\Middleware\MiddlewareStructure;
 use NetBulletin\Http\Request;
 use NetBulletin\ApiResponse;
 use NetBulletin\Helpers\FileHelper;
 use NetBulletin\Lib\Member;
 use NetBulletin\Helpers\UtilityHelper;

 /**
  * Class LocalizationMiddleware
  *
  * Service for handling localization.
  */
 class LocalizationMiddleware implements MiddlewareStructure {
   /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * The member library object instance.
     *
     * @var object
     */
    private $member;

    /**
     * Prevent cloning of the instance.
     *
     * @return void
     */
    public function __clone() {}

    /**
     * Prevent unserializing of the instance.
     */
    public function __wakeup() {}

   /**
    * Localization translations collection.
    *
    * @var array
    */
   private $lang = [];

   /**
     * Returns a singleton instance.
     *
     * @return object
     */
   public static function getInstance() {
      if (self::$instance === null) {
         self::$instance = new self();
      }

      return self::$instance;
   }

   /**
    * Loads the localization translations.
    *
    * @return void
    */
   private function load() {
      $this->member = Member::getInstance();
      $manifest = json_decode(FileHelper::readFile($this->member->localizationPath() . 'manifest.json', true));

      foreach ($manifest['files'] as $file) {
         if (!file_exists($this->member->localizationPath() . $file)) {

         }

         $thisFile = json_decode(FileHelper::readFile($this->member->localizationPath() . $file), true);

         foreach ($thisFile as $stringId => $stringValue) {
            $this->lang[UtilityHelper::getStringBeforeCharacter($file, '.')][$stringId] = $stringValue;
         }
      }
   }

   /**
    * Middleware that manages the localization.
    *
    * @param Request $request the request object
    * @param callable $next the next middleware to execute
    * @return void
    */
   public function handle(Request $request, callable $next) {
      $this->load();
      $request->localization = $this;
      return $next($request);
   }

   /**
    * Returns the entire localization collection.
    *
    * @return array localization collection
    */
   public function getAll() {
      return $this->lang;
   }

   /**
    * Returns the specified localization category collection.
    *
    * @param string $category the category name
    * @return array category localization collection
    */
   public function getCategory($category) {
      return $this->lang[$category];
   }

   /**
    * Returns the localization for the given category and string ID
    * combination.
    *
    * @param string $category the category name
    * @param string $stringId the string identifier
    * @return string localized string
    */
   public function get($category, $stringId) {
      return $this->lang[$category][$stringId];
   }

   /**
    * Replaces the given string with the given replacement.
    *
    * @param string $string the string to replace
    * @param string $toReplace the string to replace
    * @param string $replacement the replacement string
    * @return string the resulting string
    */
   public function replace($string, $toReplace, $replacement) {
      return str_replace($toReplace, $replacement, $string);
   }

   /**
    * Quickly replaces by including the category and string ID in the
    * parameters.
    *
    * @param string $category the category name
    * @param string $stringId the string identifier
    * @param string $replacement the replacement string
    * @return string the resulting string
    */
   public function quickReplace($category, $stringId, $toReplace, $replacement) {
      return $this->replace($this->get($category, $stringId), $toReplace, $replacement);
   }

   /**
    * Replaces multiple replacements at once.
    *
    * @param string $string the string to replace
    * @param array $replacements the replacements associate array collection
    * @return string the resulting string
    */
   public function replaceAll($string, $replacements = []) {
      foreach ($replacements as $k => $v) {
         $string = $this->replace($string, $k, $v);
      }

      return $string;
   }

   /**
    * Quickly replaces all the given replacements.
    *
    * @param string $string the string to replace in
    * @param string $category the category name
    * @param string $stringId the string identifier
    * @param array $replacements collection of replaces in associate array
    * @return string the resulting string
    */
   public function quickReplaceAll($string, $category, $stringId, $replacements = []) {
      $words = $this->get($category, $stringId);

      foreach ($replacements as $k => $v) {
         $words = $this->replace($string, $k, $v);
      }

      return $words;
   }
 }