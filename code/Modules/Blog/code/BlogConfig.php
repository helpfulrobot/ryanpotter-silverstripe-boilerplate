<?php

/**
 * Class BlogConfig
 *
 * @property string DisqusForumShortName
 */
class BlogConfig extends DataExtension
{
    /**
     * @var array
     */
    public static $db = array(
        'DisqusForumShortName' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    public static $defaults = array();

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        /** -----------------------------------------
         * Comments
         * ----------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Comments', 'Comments');
        /** @var TextField $disqusForumShortName */
        $fields->addFieldsToTab('Root.Settings.Comments',
            array(
                HeaderField::create('CommentsTabHeading', _t('BlogConfig.Comments', 'Comments')),
                LiteralField::create('CommentsTabDescription',
                    _t('BlogConfig.CommentsTabDescription',
                        '<p>If the Disqus Forum Shortname is set Blog Pages will have a comment section appended to the bottom of the article.</p>')
                ),
                $disqusForumShortName = TextField::create('DisqusForumShortName',
                    _t('BlogConfig.DisqusForumShortName', 'Disqus Forum Shortname'))
            )
        );
        if (!SiteConfig::current_site_config()->DisqusForumShortName) {
            $disqusForumShortName->setRightTitle(_t('BlogConfig.DisqusForumShortNameRightTitle',
                'Enables Disqus commenting on blog items. Sign up for your Disqus account at: <a href="http://disqus.com/" target="_blank">http://disqus.com/</a>'));
        }

    }

}
