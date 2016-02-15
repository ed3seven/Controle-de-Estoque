

<!DOCTYPE html>
<html lang="pt">
  <head>
    <title>Calmaria by Leyd</title>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo get_the_excerpt(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="theme-color" content="#005c7f">

    <link rel="canonical" href="<?php the_permalink() ?>" itemprop="url">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/style.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/normalize.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/magic.min.css" />
    <link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/favicn.ico" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link href='https://fonts.googleapis.com/css?family=Gloria+Hallelujah' rel='stylesheet' type='text/css'>

    <script src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

      <script src="<?php bloginfo('template_directory');?>/js/bootstrap.js"></script>
      <script src="<?php bloginfo('template_directory');?>/js/umd/scrollspy.js"></script>
      <script src="<?php bloginfo('template_directory');?>/js/truncate.js"></script>

        <script src="<?php bloginfo('template_directory');?>/js/jquery.superscrollorama.js"></script>
        <script src="<?php bloginfo('template_directory');?>/js/tweenmax.min.js"></script>

        <script src="<?php bloginfo('template_directory');?>/scripts/sticky.min.js"></script>
        <script src="<?php bloginfo('template_directory');?>/scripts/basic.js"></script>

<meta property="og:url"                content="<?php the_permalink() ?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="<?php the_title(); ?>" />
<meta property="og:description"        content="How much does culture influence creative thinking?" />
<meta property="og:image"              content="<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64997828-1', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '938400292884338',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/pt_BR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<?php  wp_head(); ?>

</head>

<?php
/**
 * Abstract class which has helper functions to get data from the database
 */
abstract class Base_Custom_Data
{
    /**
     * The current table name
     *
     * @var boolean
     */
    private $tableName = false;

    /**
     * Constructor for the database class to inject the table name
     *
     * @param String $tableName - The current table name
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Insert data into the current data
     *
     * @param  array  $data - Data to enter into the database table
     *
     * @return InsertQuery Object
     */
    public function insert(array $data)
    {
        global $wpdb;

        if(empty($data))
        {
            return false;
        }

        $wpdb->insert($this->tableName, $data);

        return $wpdb->insert_id;
    }

    /**
     * Get all from the selected table
     *
     * @param  String $orderBy - Order by column name
     *
     * @return Table result
     */
    public function get_all( $orderBy = NULL )
    {
        global $wpdb;

        $sql = 'SELECT * FROM `'.$this->tableName.'`';

        if(!empty($orderBy))
        {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        $all = $wpdb->get_results($sql);

        return $all;
    }

    /**
     * Get a value by a condition
     *
     * @param  Array $conditionValue - A key value pair of the conditions you want to search on
     * @param  String $condition - A string value for the condition of the query default to equals
     *
     * @return Table result
     */
    public function get_by(array $conditionValue, $condition = '=', $returnSingleRow = FALSE)
    {
        global $wpdb;

        try
        {
            $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE ';

            $conditionCounter = 1;
            foreach ($conditionValue as $field => $value)
            {
                if($conditionCounter > 1)
                {
                    $sql .= ' AND ';
                }

                switch(strtolower($condition))
                {
                    case 'in':
                        if(!is_array($value))
                        {
                            throw new Exception("Values for IN query must be an array.", 1);
                        }

                        $sql .= $wpdb->prepare('`%s` IN (%s)', $field, implode(',', $value));
                        break;

                    default:
                        $sql .= $wpdb->prepare('`'.$field.'` '.$condition.' %s', $value);
                        break;
                }

                $conditionCounter++;
            }

            $result = $wpdb->get_results($sql);

            // As this will always return an array of results if you only want to return one record make $returnSingleRow TRUE
            if(count($result) == 1 && $returnSingleRow)
            {
                $result = $result[0];
            }

            return $result;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    /**
     * Update a table record in the database
     *
     * @param  array  $data           - Array of data to be updated
     * @param  array  $conditionValue - Key value pair for the where clause of the query
     *
     * @return Updated object
     */
    public function update(array $data, array $conditionValue)
    {
        global $wpdb;

        if(empty($data))
        {
            return false;
        }

        $updated = $wpdb->update( $this->tableName, $data, $conditionValue);

        return $updated;
    }

    /**
     * Delete row on the database table
     *
     * @param  array  $conditionValue - Key value pair for the where clause of the query
     *
     * @return Int - Num rows deleted
     */
    public function delete(array $conditionValue)
    {
        global $wpdb;

        $deleted = $wpdb->delete( $this->tableName, $conditionValue );

        return $deleted;
    }
}
?>