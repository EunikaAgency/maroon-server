<?php

namespace AIOSEO\Plugin\Pro\SeoAnalysis;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use AIOSEO\Plugin\Common\SeoAnalysis as CommonSeoAnalysis;
use AIOSEO\Plugin\Pro\Models;
use AIOSEO\Plugin\Common\Models as CommonModels;
/**
 * Handles the SEO validation.
 *
 * @since 4.8.6
 */
class SeoAnalysis extends CommonSeoAnalysis\SeoAnalysis {
	/**
	 * The Basic codes by severity.
	 *
	 * @since 4.8.6
	 *
	 * @var array
	 */
	public $basicCodesStatus = [
		'passed'  => [
			'title-ok',
			'description-ok',
			'h1-ok',
			'subheading-ok',
			'image-ok',
			'links-ratio-ok',
			'thumbnail-ok',
			'content-length-ok',
			'keyword-cannibalization-ok',
			'first-paragraph-ok',
			'title-focus-keyword-ok',
			'description-focus-keyword-ok',
			'url-focus-keyword-ok',
			'url-length-ok',
			'product-schema-ok'
		],
		'warning' => [
			'title-too-short',
			'description-too-short',
			'subheading-missing',
			'subheading-missing-focus-keyword',
			'thumbnail-missing',
			'content-length-too-short',
			'url-length-too-long'
		],
		'error'   => [
			'title-missing',
			'title-too-long',
			'description-missing',
			'description-too-long',
			'h1-missing',
			'h1-too-many',
			'h1-missing-focus-keyword',
			'image-missing',
			'image-missing-alt',
			'internal-links-missing',
			'internal-links-too-few',
			'keyword-cannibalization',
			'first-paragraph-missing-focus-keyword',
			'title-missing-focus-keyword',
			'description-missing-focus-keyword',
			'url-missing-focus-keyword',
			'product-schema-missing'
		]
	];

	/**
	 * The Advanced codes by severity.
	 *
	 * @since 4.8.6
	 *
	 * @var array
	 */
	public $advancedCodesStatus = [
		'passed'  => [
			'noindex-ok',
			'ogp-ok',
			'schema-ok',
			'canonical-ok',
			'content-keywords-ok',
			'author-bio-ok',
			'main-keyword-ok',
			'stale-content-ok'
		],
		'warning' => [
			'noindex',
			'canonical-missing',
			'content-keywords-missing',
			'author-bio-missing',
			'main-keyword-missing',
			'stale-content-too-old'
		],
		'error'   => [
			'ogp-missing',
			'ogp-duplicates',
			'schema-missing'
		]
	];

	/**
	 * The Performance codes by severity.
	 *
	 * @since 4.8.6
	 *
	 * @var array
	 */
	public $performanceCodesStatus = [
		'passed'  => [ 'requests' ],
		'warning' => [],
		'error'   => []
	];

	/**
	 * Constructor.
	 *
	 * @since 4.8.6
	 */
	public function __construct() {
		// Initialize the post and term scans.
		new ActionScheduler\Post();
		new ActionScheduler\Term();
	}

	/**
	 * Returns the data for Vue.
	 *
	 * @since 4.8.6
	 *
	 * @return array The data for Vue.
	 */
	public function getVueData() {
		return parent::getVueData();
	}

	/**
	 * Analyze the post.
	 *
	 * @since 4.8.6
	 *
	 * @param  int   $objectId The object ID.
	 * @return array
	 */
	public function analyzePost( $objectId ) {
		$post       = get_post( $objectId );
		$content    = $post && 'publish' !== $post->post_status ? apply_filters( 'the_content', $post->post_content ) : '';
		$isScraping = $post && 'publish' === $post->post_status;
		$pageParser = new PageParser( get_permalink( $objectId ), $content, $isScraping );
		if ( ! $pageParser->hasDocument() ) {
			return [
				'results' => [
					'basic'    => [],
					'advanced' => []
				],
			];
		}

		$results = [
			'basic'    => ( new Checkers\Post\Basic( $objectId, $pageParser ) )->get(),
			'advanced' => ( new Checkers\Post\Advanced( $objectId, $pageParser ) )->get()
		];

		return [
			'results' => $results,
		];
	}

	/**
	 * Analyze the term.
	 *
	 * @since 4.8.6
	 *
	 * @param  int   $objectId The object ID.
	 * @return array
	 */
	public function analyzeTerm( $objectId ) {
		$term = get_term( $objectId );
		$results = [
			'results' => [
				'basic'    => [],
				'advanced' => []
			],
		];

		if ( is_wp_error( $term ) || ! $term || empty( $term->taxonomy ) ) {
			return $results;
		}

		$publicTaxonomies = array_diff( aioseo()->helpers->getPublicTaxonomies( true ), [ 'product_attributes' ] );
		if ( ! in_array( $term->taxonomy, $publicTaxonomies, true ) ) {
			return $results;
		}

		$termLink = get_term_link( $term, $term->taxonomy );
		if ( is_wp_error( $termLink ) || ! $termLink ) {
			return $results;
		}

		$pageParser = new PageParser( $termLink );
		if ( ! $pageParser->hasDocument() ) {
			return $results;
		}

		$results = [
			'basic'    => ( new Checkers\Term\Basic( $objectId, $pageParser, $term->taxonomy ) )->get(),
			'advanced' => ( new Checkers\Term\Advanced( $objectId, $pageParser, $term->taxonomy ) )->get()
		];

		return [
			'results' => $results,
		];
	}

	/**
	 * Get all codes.
	 *
	 * @since 4.8.6
	 *
	 * @return array The list of codes.
	 */
	public function getAllCodes() {
		$codes = [];

		foreach ( [ 'basic', 'advanced', 'performance' ] as $type ) {
			$codes = array_merge( $codes, $this->{$type . 'CodesStatus'}['passed'], $this->{$type . 'CodesStatus'}['warning'], $this->{$type . 'CodesStatus'}['error'] );
		}

		return $codes;
	}

	/**
	 * Get the codes by status.
	 *
	 * @since 4.8.6
	 *
	 * @param  string $status The status code (passed, warning, error).
	 * @return array          The list of codes.
	 */
	public function getCodesByStatus( $status ) {
		if ( ! in_array( $status, $this->getStatusAvailable(), true ) ) {
			return [];
		}

		$codes = [];
		foreach ( [ 'basic', 'advanced', 'performance' ] as $type ) {
			$codes = array_merge( $codes, $this->{$type . 'CodesStatus'}[ $status ] );
		}

		return $codes;
	}

	/**
	 * Get the group by code and status.
	 *
	 * @since 4.8.6
	 *
	 * @param  string      $code   The code.
	 * @param  string      $status The status code (passed, warning, error).
	 * @return string|null         The group name
	 */
	public function getGroupByCodeAndStatus( $code, $status ) {
		if ( ! in_array( $status, $this->getStatusAvailable(), true ) ) {
			return null;
		}

		foreach ( [ 'basic', 'advanced', 'performance' ] as $type ) {
			if ( in_array( $code, $this->{$type . 'CodesStatus'}[ $status ], true ) ) {
				return $type;
			}
		}

		return null;
	}

	/**
	 * Get the available status.
	 *
	 * @since 4.8.6
	 *
	 * @return array
	 */
	private function getStatusAvailable() {
		return [ 'passed', 'warning', 'error' ];
	}

	/**
	 * Clear the homepage results.
	 *
	 * @since 4.8.6
	 *
	 * @param  int    $objectId   The object ID.
	 * @param  string $objectType The object type.
	 */
	public function clearHomepageResults( $objectId, $objectType ) {
		if ( ! aioseo()->helpers->isStaticHomePage( $objectId ) ) {
			return;
		}

		Models\Issue::deleteAll( $objectId, $objectType );

		aioseo()->internalOptions->internal->siteAnalysis->score = 0;
		CommonModels\SeoAnalyzerResult::deleteByUrl( null );

		aioseo()->core->cache->delete( 'analyze_site_code' );
		aioseo()->core->cache->delete( 'analyze_site_body' );
	}

	/**
	 * Get all codes sorted by group and status.
	 *
	 * @since 4.8.6
	 *
	 * @param  string|null $status The status code (passed, warning, error).
	 * @return array
	 */
	public function getAllCodesSortedByGroupAndStatus( $status = null ) {
		if ( ! empty( $status ) && ! in_array( $status, $this->getStatusAvailable(), true ) ) {
			return [];
		}

		$result = [];
		foreach ( [ 'basic', 'advanced', 'performance' ] as $type ) {
			foreach ( $this->{$type . 'CodesStatus'} as $st => $group ) {
				if ( ! empty( $status ) && $st !== $status ) {
					continue;
				}

				foreach ( $group as $key => $code ) {
					$result[ $type ][ $st ][ $code ] = $key;
				}
			}
		}

		return $result;
	}

	/**
	 * Get the objects scan percent.
	 *
	 * @since 4.8.6
	 *
	 * @return int The percent completed as an integer.
	 */
	public function getObjectsScanPercent() {
		$posts = $this->getPostsScanPercent();
		$terms = $this->getTermsScanPercent();

		// We need to divide by 2 because we are averaging the two percentages.
		return round( ( $posts + $terms ) / 2 );
	}

	/**
	 * Get the posts scan percent.
	 *
	 * @since 4.8.6
	 *
	 * @return int The percent completed as an integer.
	 */
	private function getPostsScanPercent() {
		$publicPostTypes    = aioseo()->helpers->getScannablePostTypes();
		$publicPostStatuses = aioseo()->helpers->getPublicPostStatuses( true );

		$aioseoPostsTableName = aioseo()->core->db->prefix . 'aioseo_posts';
		$postsTableName       = aioseo()->core->db->prefix . 'posts';

		$implodedPostTypes    = aioseo()->helpers->implodeWhereIn( $publicPostTypes, true );
		$implodedPostStatuses = aioseo()->helpers->implodeWhereIn( $publicPostStatuses, true );

		$totals = aioseo()->core->db->execute(
			aioseo()->core->db->db->prepare(
				"SELECT (
					SELECT count(*)
					FROM {$postsTableName}
					WHERE post_type IN ( $implodedPostTypes )
						AND post_status IN ( $implodedPostStatuses )
				) as totalPosts,
				(
					SELECT count(*)
					FROM {$postsTableName} as p
					LEFT JOIN {$aioseoPostsTableName} as ap ON ap.post_id = p.ID
					WHERE p.post_type IN ( $implodedPostTypes )
						AND p.post_status IN ( $implodedPostStatuses )
						AND ( ap.post_id IS NULL
							OR ap.seo_analyzer_scan_date IS NOT NULL
						)
				) as scannedPosts
				FROM {$postsTableName}
				LIMIT 1"
			),
			true
		)->result();

		if ( ! is_object( $totals[0] ) || 1 > $totals[0]->totalPosts ) {
			return 100;
		}

		return round( 100 * ( $totals[0]->scannedPosts / $totals[0]->totalPosts ) );
	}

	/**
	 * Get the terms scan percent.
	 *
	 * @since 4.8.6
	 *
	 * @return int The percent completed as an integer.
	 */
	private function getTermsScanPercent() {
		$publicTaxonomies = array_diff( aioseo()->helpers->getPublicTaxonomies( true ), [ 'product_attributes' ] );

		$aioseoTermsTableName   = aioseo()->core->db->prefix . 'aioseo_terms';
		$termsTableName         = aioseo()->core->db->prefix . 'terms';
		$termsTaxonomyTableName = aioseo()->core->db->prefix . 'term_taxonomy';

		$implodedPublicTaxonomies = aioseo()->helpers->implodeWhereIn( $publicTaxonomies, true );

		$totals = aioseo()->core->db->execute(
			aioseo()->core->db->db->prepare(
				"SELECT (
					SELECT count(*)
					FROM {$termsTableName} as t
					INNER JOIN {$termsTaxonomyTableName} as tt ON tt.term_id = t.term_id
					WHERE tt.taxonomy IN ( $implodedPublicTaxonomies )
				) as totalTerms,
				(
					SELECT count(*)
					FROM {$termsTableName} as t
					INNER JOIN {$termsTaxonomyTableName} as tt ON tt.term_id = t.term_id
					LEFT JOIN {$aioseoTermsTableName} as at ON at.term_id = t.term_id
					WHERE tt.taxonomy IN ( $implodedPublicTaxonomies )
						AND ( at.term_id IS NULL
							OR at.seo_analyzer_scan_date IS NOT NULL
						)
				) as scannedTerms
				FROM {$termsTableName}
				LIMIT 1"
			),
			true
		)->result();

		if ( ! is_object( $totals[0] ) || 1 > $totals[0]->totalTerms ) {
			return 100;
		}

		return round( 100 * ( $totals[0]->scannedTerms / $totals[0]->totalTerms ) );
	}

	/**
	 * Enqueues a post page to be scanned by the SEO Analyzer.
	 *
	 * @since 4.8.7
	 *
	 * @param  int  $postId The post id.
	 * @return void
	 */
	public function enqueuePostToScan( $postId ) {
		$postType           = get_post_type( (int) $postId );
		$postTypesToExclude = apply_filters( 'aioseo_seo_analyzer_scan_post_types_to_exclude', [ 'scheduled-action', 'revision', 'attachment' ] );
		if (
			in_array( $postType, $postTypesToExclude, true ) ||
			! aioseo()->helpers->isPostTypePublic( $postType )
		) {
			return;
		}

		$aioseoPost = CommonModels\Post::getPost( $postId );
		$aioseoPost->seo_analyzer_scan_date = null;
		$aioseoPost->save();

		// Delete issues
		Models\Issue::deleteAll( $postId, 'post' );
	}
}