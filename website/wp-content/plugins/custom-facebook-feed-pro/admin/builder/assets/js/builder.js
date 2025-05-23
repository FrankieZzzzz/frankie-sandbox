var cffBuilder,
	cffStorage = window.localStorage,
	sketch = VueColor.Sketch;

// function foldAdminMenu() {
// 	let url = new URL(window.location)
// 	if (! url.search) return

// 	let params = new URLSearchParams(url.search);
// 	if (! params.has('feed_id') || params.get('page') != 'cff-feed-builder') return

// 	const body = document.querySelector('.facebook-feed_page_cff-feed-builder')
// 	body.classList.add('folded')
// }
// foldAdminMenu()

/**
 * VueJS Iframe, Link, Video Component
 *
 * @since 4.0
 */
Vue.component('cff-iframe-media-component', {
    name: 'cff-iframe-media-component',
    template: '#cff-iframe-media-component',
    props: ['postmedia','customizerFeedData','singlePost'],
    methods : {
    	/**
		 * Check Whether to display the Iframe (video + sound)
		 * Depending on the feed settings
		 *
		 * @since 4.0
		 *
		 * @return bool
		 */
		checkIframePostDisplay : function( postMedia ){
			var self = this;
			return postMedia.type == 'embed' &&
			(
				( self.customizerFeedData.settings.include.includes('media') && postMedia.site == 'video' )
				||
				( self.customizerFeedData.settings.include.includes('sharedlinks') && postMedia.site != 'video' )
			);
		},
    }
});


/**
 * VueJS Post Preview Components
 *
 * @since 4.0
 */
var postPreviewComponents = [
		'author',
		'text',
		'event-detail',
		'media',
		'meta',
		'overlay',
		'lightbox',
		'full-layout',
		'half-layout',
		'half-theme-layout',
		'thumb-layout',
		'videosposts',
		'reviewsposts',
		'dummy-lightbox',
		'likebox',
		'actionlinks',
	];

postPreviewComponents.forEach( function( component ) {
	var nameComponent = 'cff-post-'+component+'-component';
	Vue.component( nameComponent , {
	    template: '#' + nameComponent,
	    props: ['singlePost','customizerFeedData','translatedText','parent','lightBox','dummyLightBoxData']
	});
});



/**
 * VueJS Global App Builder
 *
 * @since 4.0
 */
cffBuilder = new Vue({
	el: '#cff-builder-app',
	http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    components: {
	    'sketch-picker': sketch,
    },
	mixins: [VueClickaway.mixin],
	data: {
		plugin_path: cff_builder.cff_plugin_path,
		nonce : cff_builder.nonce,
		plugins: cff_builder.installPluginsPopup,
		supportPageUrl: cff_builder.supportPageUrl,
		builderUrl 	: cff_builder.builderUrl,
		iCalURLs 	: cff_builder.iCalURLs,
		pluginType	: cff_builder.pluginType,
		genericText	: cff_builder.genericText,
		ajaxHandler : cff_builder.ajax_handler,
		adminPostURL : cff_builder.adminPostURL,
		widgetsPageURL : cff_builder.widgetsPageURL,
		translatedText : cff_builder.translatedText,
		socialShareLink : cff_builder.socialShareLink,
		manualSourcePopupInit : cff_builder.manualSourcePopupInit,
		shouldDisableProFeatures : cff_builder.shouldDisableProFeatures,
		recheckLicenseStatus: null,
		welcomeScreen	 : cff_builder.welcomeScreen,
		allFeedsScreen 	 : cff_builder.allFeedsScreen,
		extensionsPopup  : cff_builder.extensionsPopup,
		mainFooterScreen : cff_builder.mainFooterScreen,
		embedPopupScreen : cff_builder.embedPopupScreen,

		selectSourceScreen 		: cff_builder.selectSourceScreen,
		customizeScreensText 	: cff_builder.customizeScreens,
		dialogBoxPopupScreen   	: cff_builder.dialogBoxPopupScreen,
		selectFeedTypeScreen 	: cff_builder.selectFeedTypeScreen,
		selectFeedTemplateScreen 	: cff_builder.selectFeedTemplateScreen,
		selectFeedThemeScreen 	: cff_builder.selectFeedThemeScreen,
		addFeaturedPostScreen 	: cff_builder.addFeaturedPostScreen,
		addFeaturedAlbumScreen 	: cff_builder.addFeaturedAlbumScreen,
		addVideosPostScreen 	: cff_builder.addVideosPostScreen,
		dummyLightBoxData 		: cff_builder.dummyLightBoxData,
		addEventiCalUrlScreen 	: cff_builder.addEventiCalUrlScreen,

		svgIcons 	: cff_svgs,
		feedsList 	: cff_builder.feeds,
		feedTypes 	: cff_builder.feedTypes,
		feedTemplates 	: cff_builder.feedTemplates,
		feedThemes 	: cff_builder.feedThemes,
		previewTheme: '',
		socialInfo 	: cff_builder.socialInfo,
		sourcesList : cff_builder.sources,
		links : cff_builder.links,
		legacyFeedsList   : cff_builder.legacyFeeds,
		activeExtensions  : cff_builder.activeExtensions,
		advancedFeedTypes : cff_builder.advancedFeedTypes,
		loaderSVG : cff_svgs.loaderSVG,
		groupSourcesNumber : cff_builder.groupSourcesNumber,
		//Selected Feed type => TimeLine / Photos ... or Advanced ones!
		selectedFeed : 'timeline',

		// Selected Feed Template
		selectedFeedTemplate : 'default',
		selectedFeedTheme : 'default_theme',

		// Will be changed depending on the feed type Selected ()
		type : [
			'links',
			'events',
			'videos',
			'photos',
			'albums',
			'statuses'
		],

		selectedSources : [],
		viewsActive : {
			//Screens where the footer widget is disabled
			footerDiabledScreens : [
				'welcome',
				'selectFeed'
			],
			footerWidget : false,

			// welcome, selectFeed
			pageScreen : 'welcome',

			// feedsType, selectSource, selectTemplate, feedsTypeGetProcess
			selectedFeedSection : 'feedsType',

			sourcePopup : false,
			feedtypesPopup : false,
			feedtemplatesPopup : false,
			feedthemePopup: false,
			// step_1 [Add New Source] , step_2 [Connect to a user pages/groups], step_3 [Add Manually]
			sourcePopupScreen : 'redirect_1',
			whyRenewLicense : false,
			licenseLearnMore : false,
			// creation or customizer
			sourcePopupType : 'creation',
			extensionsPopupElement : false,
			feedTypeElement : null,
			feedTemplateElement : null,
			feedThemeElement : null,
			feedThemeDropdown: false,
			instanceFeedActive : null,
			clipboardCopiedNotif : false,
			legacyFeedsShown : false,
			editName : false,
			embedPopup : false,
			embedPopupScreen : 'step_1',
			embedPopupSelectedPage : null,

            // onboarding
			onboardingPopup : cff_builder.allFeedsScreen.onboarding.active,
            onboardingStep : 1,

			// customizer onboarding
			onboardingCustomizerPopup : cff_builder.customizeScreens.onboarding.active,

			// plugin install popup
			installPluginPopup : false,
			installPluginModal: 'instagram',
	        iCalUrlPopup : false,
        },

        //Feeds Pagination
        feedPagination : {
        	feedsCount  : cff_builder.feedsCount != undefined ? cff_builder.feedsCount : null,
        	pagesNumber : 1,
        	currentPage : 1,
        	itemsPerPage : cff_builder.itemsPerPage != undefined ? cff_builder.itemsPerPage : null,
        },

		//Add New Source
		newSourceData 		 : cff_builder.newSourceData ? cff_builder.newSourceData : null,
		sourceConnectionURLs : cff_builder.sourceConnectionURLs,
		returnedApiSourcesList : [],
		addNewSource : {
			typeSelected 		: 'page',
			manualSourceID 		: null,
			manualSourceToken 	: null,
			eventsManualSourceICal 	: null
		},
		selectedSourcesToConnect : [],

		//Feeds Types Get Info
		extraProcessFeedsTypes : [
			//'events',
			'singlealbum',
			'featuredpost',
			'videos'
		],
		isCreateProcessGood : false,
		feedCreationInfoUrl : null,
		feedsSelected : [],
		selectedBulkAction : false,
		singleAlbumFeedInfo : {
			url : '',
			info : {},
			success: false,
			isError : false
		},
		featuredPostFeedInfo : {
			url : '',
			info : {},
			success: false,
			isError : false
		},
		videosTypeInfo : {
			type : 'all',
			info : {},
			playListUrl : null,
			success: false,
			playListUrlError : false
		},
		eventFeedInfo : {
			url : '',
			info : {},
			success: false,
			isError : false
		},

		customizerFeedDataInitial : null,
		customizerFeedData 	: cff_builder.customizerFeedData,
		wordpressPageLists  : cff_builder.wordpressPageLists,
		iscustomizerScreen  	: (cff_builder.customizerFeedData != undefined && cff_builder.customizerFeedData != false),

		customizerSidebarBuilder : cff_builder.customizerSidebarBuilder,
		cffLicenseNoticeActive: (cff_builder.cffLicenseNoticeActive === '1'),
		cffLicenseInactiveState: (cff_builder.cffLicenseInactiveState === '1'),
		licenseKey : cff_builder.licenseKey,
		licenseBtnClicked : false,
		customizerScreens : {
			activeTab 		: 'customize',
			printedType 	: {},
			printedTemplate : {},
			printedTheme: {},
			activeSection 	: null,
			previewScreen 	: 'desktop',
			sourceExpanded 	: null,
			sourcesChoosed 	: [],
			inputNameWidth 	: '0px',
			activeSectionData 	: null,
			parentActiveSection : null, //For nested Setions
			parentActiveSectionData : null, //For nested Setions
			activeColorPicker : null,
			popupBackButton : ['photos','videos','albums','events','reviews','featuredpost','singlealbum','socialwall', 'feedTemplate']
		},
		previewScreens: [
			'desktop',
			'tablet',
			'mobile'
		],

		nestedStylingSection : [
			'post_styling_author',
			'post_styling_text',
			'post_styling_date',
			'post_styling_media',
			'post_styling_social',
			'post_styling_eventtitle',
			'post_styling_eventdetails',
			'post_styling_link',
			'post_styling_desc',
			'post_styling_sharedlinks'
		],

		sourceToDelete : {},
		feedToDelete : {},
		dialogBox : {
			active : false,
			type : null, //deleteSourceCustomizer
			heading : null,
			description : null
		},

		feedStyle : '',
		expandedPostText : [],
		showedSocialShareTooltip : null,
		showedCommentSection : [],

		//LightBox Object
		lightBox : {
			visibility 	: 'hidden',
			type 		: null,
			post 		: null,
			activeImage : null,
			albumIndex : 0,
			videoSource : null
		},
		highLightedSection : 'all',

		tooltip : {
			text : '',
			hover : false,
			hoverType : 'outside'
		},
		//Loading Bar
		fullScreenLoader : false,
		appLoaded : false,
		previewLoaded : false,
		loadingBar : true,
		notificationElement : {
			type : 'success', // success, error, warning, message
			text : '',
			shown : null
		},

		sw_feed: false,
		sw_feed_id: false,
        license_tier_features : cff_builder.license_tier_features,

		addIcalUrl : {
			reconnectPage : false,
			pageToken : null,
			url : null,
			source_id : null,
			loadingAjax : false,
			success: false,
			isError : false,
			errorMessage : ''
		},
		showEventsTimezoneNotice : false,
		showEventsTimezoneNoticeType : "fix"
	},
	computed : {
		feedStyleOutput : function(){
			return this.customizerStyleMaker();
		},
		singleHolderData : function(){
			return this.singleHolderParams();
		}

	},
	created: function(){
		var self = this;
		const urlParams = new URLSearchParams(window.location.search);
		// get the socail wall link feed url params
		self.sw_feed = urlParams.get('sw-feed');
		self.sw_feed_id = urlParams.get('sw-feed-id');
		if( self.customizerFeedData ){
			setTimeout(function(){
				self.generateMasonryGridHeight('update');
				self.generateCarouselSettings();
			}, 2000);
			self.customizerFeedDataInitial = JSON.parse(JSON.stringify(self.customizerFeedData));
			self.customizerFeedData.settings.num = (typeof self.customizerFeedData.settings.num === 'boolean') ? '5' : self.customizerFeedData.settings.num;
			self.customizerFeedData.settings.nummobile = (typeof self.customizerFeedData.settings.nummobile === 'boolean') ? '5' : self.customizerFeedData.settings.nummobile;
			if(self.customizerFeedData.settings.sources.map === undefined) {
				self.customizerFeedData.settings.sources = [];
			}

			self.showEventsTimezoneNotice = self.customizerFeedData.settings.feedtype === 'events' && (self.customizerFeedData.settings.eventstimezoneoffsetchanged === 'false' || self.customizerFeedData.settings.eventstimezoneoffsetchanged === false);
		}

		if(self.customizerFeedData == undefined){
			if(self.sourcesList.length == 1){
				self.selectedSources.push(self.sourcesList[0].account_id);
			}
			self.feedPagination.pagesNumber = self.feedPagination.feedsCount != null ? Math.ceil(self.feedPagination.feedsCount / self.feedPagination.itemsPerPage) : 1
		}

		self.loadingBar = false;
        /* Onboarding - move elements so the position is in context */
		self.positionOnboarding();
		setTimeout(function(){
			self.positionOnboarding();
		}, 500);

		self.appLoaded = true;

	},
	methods: {
		updateColorValue : function(id){
			var self = this;
			self.customizerFeedData.settings[id] = (self.customizerFeedData.settings[id].a == 1) ? self.customizerFeedData.settings[id].hex : self.customizerFeedData.settings[id].hex8;
		},

		/**
		 * Activate license key from license error post grace period header notice
		 *
		 * @since 4.4.0
		 */
		 activateLicense: function() {
			var self = this;

			self.licenseBtnClicked = true;

			if ( self.licenseKey == null ) {
				self.licenseBtnClicked = false;
				return;
			}
			let licenseData = {
				action : 'cff_activate_license',
				nonce : cff_builder.nonce,
				license_key: self.licenseKey
			};
			self.ajaxPost(licenseData, function(_ref){
				self.licenseBtnClicked = false;
				var data = _ref.data;

				if(data && data.success == false) {
					self.processNotification("licenseError");
					return;
				}
				if( data !== false ){
					self.processNotification("licenseActivated");
					// remove license notices
                    self.viewsActive.licenseLearnMore = false;
					jQuery('#cff-license-expired-agp').slideUp();
					jQuery('#cff-builder-app').removeClass('cff-builder-app-lite-dismiss');

					jQuery('.cff_get_pro_highlight, .cff_get_sbr, .cff_get_sbi, .cff_get_yt, .cff_get_ctf').closest('li').remove();
				}
			})
		},

		/**
		 * Show & Hide View
		 *
		 * @since 4.0
		 */
		activateView : function(viewName, sourcePopupType = 'creation', ajaxAction = false){
			var self = this;
			self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;
			if(viewName === 'sourcePopup'){
				self.viewsActive.sourcePopupType = sourcePopupType;
				if(self.customizerFeedData != undefined && sourcePopupType != 'updateCustomizer'){
					Object.assign(self.customizerScreens.sourcesChoosed,self.customizerFeedData.settings.sources);
				}
				if(self.customizerFeedData != undefined && sourcePopupType == 'updateCustomizer'){
					self.viewsActive.sourcePopupType = 'customizer';
					//self.viewsActive.sourcePopup = true;
					self.customizerFeedData.settings.sources = self.customizerScreens.sourcesChoosed;
				}
				if( ajaxAction !== false ){
					self.customizerControlAjaxAction( ajaxAction );
				}
			}
			if(viewName === 'feedtypesPopup'){
				self.viewsActive.feedTypeElement = null;
			}
			if(viewName === 'feedtemplatesPopup'){
				self.viewsActive.feedTemplatesElement = null;
			}
			if(viewName === 'feedthemePopup'){
				self.viewsActive.feedThemeElement = null;
				self.viewsActive.feedThemeDropdown = self.viewsActive.feedThemeDropdown ? false : true;
			}
			if(viewName === 'extensionsPopupElement' && self.customizerFeedData !== undefined){
				//self.activateView('feedtypesPopup');
			}
			if(viewName == 'editName'){
				document.getElementById("cff-csz-hd-input").focus();
			}
			if(viewName == 'embedPopup' && ajaxAction == true){
				self.saveFeedSettings();
			}

			if((viewName == 'sourcePopup' || viewName == 'sourcePopupType') && sourcePopupType == 'creationRedirect'){
				if( self.$refs.addSourceRef.addNewSource.typeSelected == 'page'  && self.selectedFeed == 'events' ){
					self.viewsActive.sourcePopupScreen = 'step_1_event';
				}else{
					self.viewsActive.sourcePopupScreen = 'redirect_1';
					setTimeout(function(){
						self.$refs.addSourceRef.processFBConnect()
					},3500);
				}


			}

			cffBuilder.$forceUpdate();
			self.movePopUp();
		},
		recheckLicense: function( optionName = null ) {
			var self = this;
			var licenseNoticeWrapper = document.querySelector('.sb-license-notice');
            self.recheckLicenseStatus = 'loading';
			recheckLicenseData = {
				action : 'cff_recheck_connection',
				license_key : self.licenseKey,
			};
			self.ajaxPost(recheckLicenseData, function(_ref){
				var data = _ref.data;
				if ( data.success == true ) {
                    if ( data.data.license == 'valid' ) {
                        self.recheckLicenseStatus = 'success';
                    }
                    if ( data.data.license != 'valid' ) {
                        self.recheckLicenseStatus = 'error';
                    }

                    setTimeout(function() {
                        self.recheckLicenseStatus = null;
						if ( data.data.license == 'valid' ) {
							licenseNoticeWrapper.remove();
						}
                    }.bind(this), 3000);
                }
                return;
			});
        },
        recheckBtnText: function() {
			var self = this;
            if ( self.recheckLicenseStatus == null ) {
                return self.genericText.recheckLicense;
            } else if ( self.recheckLicenseStatus == 'loading' ) {
                return self.svgIcons.loaderSVG + ' ' + self.genericText.recheckLicense;
            } else if ( self.recheckLicenseStatus == 'success' ) {
                return self.svgIcons.checkmarkSVG + ' ' + self.genericText.licenseValid;
            } else if ( self.recheckLicenseStatus == 'error' ) {
                return self.svgIcons.times2SVG + ' ' + self.genericText.licenseExpired;
            }
        },
		/**
		 * Show/Hide View or Redirect to plugin dashboard page
		 *
		 * @since 4.0
		 */
		activateViewOrRedirect: function(viewName, pluginName, plugin) {
			var self = this;

			if ( plugin.installed && plugin.activated ) {
				window.location = plugin.dashboard_permalink;
				return;
			}

			self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;

			if(viewName == 'installPluginPopup'){
				self.viewsActive.installPluginModal = pluginName;
			}

			self.movePopUp();
			cffBuilder.$forceUpdate();
		},

		movePopUp : function(){
			var overlay = document.querySelectorAll("sb-fs-boss");
			if (overlay.length > 0) {
				document.getElementById("wpbody-content").prepend(overlay[0]);
			}
		},

		/**
		 * Check if View is Active
		 *
		 * @since 4.0
		 *
		 * @return boolean
		 */
		checkActiveView : function(viewName){
			return this.viewsActive[viewName];
		},

		/**
		 * Switch & Change Feed Screens
		 *
		 * @since 4.0
		 */
		switchScreen: function(screenType, screenName){
			this.viewsActive[screenType] = screenName;
			cffBuilder.$forceUpdate();
		},

		/**
		 * Check if Value is Empty
		 *
		 * @since 4.0
		 *
		 * @return boolean
		 */
		checkNotEmpty : function(value){
			return value != null && value.replace(/ /gi,'') != '';
		},

		/**
		 * Check if Value exists in Array Object
		 *
		 * @since 4.0
		 *
		 * @return boolean
		 */
		checkObjectArrayElement : function(objectArray, object, byWhat){
			var objectResult = objectArray.filter(function(elem){
				return elem[byWhat] == object[byWhat];
			});
			return (objectResult.length > 0) ? true : false;
		},

		/**
		 * Check if Data Setting is Enabled
		 *
		 * @since 4.0
		 *
		 * @return boolean
		 */
		valueIsEnabled : function(value){
			return value == 1 || value == true || value == 'true' || value == 'on';
		},


		/**
		 * Parse JSON
		 *
		 * @since 4.0
		 *
		 * @return jsonObject / Boolean
		 */
		jsonParse : function(jsonString){
			try {
				return JSON.parse(jsonString);
			} catch(e) {
				return false;
			}
		},


		/**
		 * Ajax Post Action
		 *
		 * @since 4.0
		 */
		ajaxPost : function(data, callback){
			var self = this;
			data['nonce'] = this.nonce;
			self.$http.post(self.ajaxHandler,data).then(callback);
		},

		/**
		 * Check if Object has Nested Property
		 *
		 * @since 4.0
		 *
		 * @return boolean
		 */
		hasOwnNestedProperty : function(obj,propertyPath) {
		  if (!propertyPath){return false;}var properties = propertyPath.split('.');
		  for (var i = 0; i < properties.length; i++) {
		    var prop = properties[i];
		    if (!obj || !obj.hasOwnProperty(prop)) {
		      return false;
		    } else {
		      obj = obj[prop];
		    }
		  }
		  return true;
		},

		backToPrevPopup() {
			var self = this;
            if( self.viewsActive.extensionsPopupElement === 'feedTemplate' ){
                self.activateView('feedtemplatesPopup');
            }else{
                self.activateView('feedtypesPopup');
            }
			self.viewsActive.extensionsPopupElement = false;
		},

		/**
		 * Feed List Pagination
		 *
		 * @since 4.0
		 */
		feedListPagination : function(type){
			var self = this,
				currentPage = self.feedPagination.currentPage,
				pagesNumber = self.feedPagination.pagesNumber;
			self.loadingBar = true;
			if((currentPage != 1 && type == 'prev') || (currentPage <  pagesNumber && type == 'next')){
				self.feedPagination.currentPage = (type == 'next') ?
					(currentPage < pagesNumber ? (parseInt(currentPage) + 1) : pagesNumber) :
					(currentPage > 1 ? (parseInt(currentPage) - 1) : 1);


				var postData = {
	                action : 'cff_feed_saver_manager_get_feed_list_page',
					page : self.feedPagination.currentPage
				};
	            self.ajaxPost(postData, function(_ref){
	                var data = _ref.data;
	                if(data){
	                	self.feedsList = data;
	                }
					self.loadingBar = false;
	            });
				cffBuilder.$forceUpdate();
			}
		},

		/**
		 * Choose Feed Type
		 *
		 * @since 4.0
		 */
		chooseFeedType : function(feedTypeGroup, feedElement, iscustomizerPopup = false){
			var self = this;
			if ( self.shouldDisableProFeatures && feedElement.type !== 'timeline' ) {
				if ( self.viewsActive.feedtypesPopup ) {
					self.activateView('feedtypesPopup');
				}
				self.viewsActive.extensionsPopupElement = feedElement.type;
				return;
			}
			if(feedTypeGroup == 'advanced' && feedElement.extensionActive !== true && !self.shouldDisableProFeatures){
				self.viewsActive.extensionsPopupElement = feedElement.type;
				if(self.customizerFeedData !== undefined){
					self.activateView('feedtypesPopup');
				}
				self.selectedFeed = 'timeline';
			} else {
				self.selectedFeed = feedElement.type;
			}
			if(iscustomizerPopup){
				self.viewsActive.feedTypeElement = self.selectedFeed;
			}else{
				self.setType( self.selectedFeed );
			}

			if (self.selectedFeed === null) {
				self.selectedFeed = 'timeline';
			}
			cffBuilder.$forceUpdate();
		},

		chooseFeedTemplate: function( feedTemplate, iscustomizerPopup = false ) {
			var self = this;
			self.selectedFeedTemplate = feedTemplate.type;
			if( iscustomizerPopup ){
				if ( self.shouldDisableProFeatures ) {
					self.activateView('feedtemplatesPopup');
					self.viewsActive.extensionsPopupElement = 'feedTemplate';
					return;
				}
				self.viewsActive.feedTemplateElement = feedTemplate.type;
			}
			if ( ( feedTemplate.type == 'showcase_carousel' || feedTemplate.type == 'simple_carousel' ) && !self.activeExtensions.carousel ) {
				self.viewsActive.extensionsPopupElement = 'carousel';
				self.selectedFeedTemplate = 'default';
				self.viewsActive.feedTemplateElement = null;
				self.viewsActive.feedtemplatesPopup = null;
				self.viewsActive.feedthemePopup = null;
			}
			cffBuilder.$forceUpdate();
		},

		chooseFeedTheme: function( feedTheme, iscustomizerPopup = false ) {
			var self = this;
			self.selectedFeedTheme = feedTheme.type;
			if( iscustomizerPopup ){
				self.viewsActive.feedThemeElement = feedTheme.type;
			}
			if ( ( feedTheme.type == 'showcase_carousel' || feedTheme.type == 'simple_carousel' ) && !self.activeExtensions.carousel ) {
				self.viewsActive.extensionsPopupElement = 'carousel';
				self.selectedFeedTemplate = 'default';
				self.viewsActive.feedTemplateElement = null;
				self.viewsActive.feedtemplatesPopup = null;
				self.viewsActive.feedthemePopup = null;
			}
			cffBuilder.$forceUpdate();
		},

		/**
		 * Set Feed Type
		 *
		 * @since 4.0
		 */
		setType : function(feedType){
			var typesArray = [], self = this;
			switch (feedType) {
				case 'photos':
					typesArray = ['photos'];
				break;
				case 'videos':
					typesArray = ['videos'];
				break;
				case 'events':
					typesArray = ['events'];
				break;
				case 'albums':
					typesArray = ['albums'];
				break;
				default:
					typesArray = ['links','events','videos','photos','albums','statuses'];
				break;
			}
			self.type = typesArray;
			if(self.customizerFeedData !== undefined){
				self.customizerFeedData.settings.type = typesArray;
				self.customizerFeedData.settings.feedtype = (typesArray.length == 1) ? typesArray[0] : 'timeline';
				self.processFeedTypesSources( typesArray );
			}
		},

		/**
		 * Get Feed Template Element Title
		 *
		 * @since 4.2.0
		 */
		getFeedTemplateElTitle : function( $el, isCustomizer = false ) {
			var title = '';
			var self = this;
			var feedType = isCustomizer ? self.customizerFeedData.settings.feedtype : self.selectedFeed;
			if ( $el.type == 'simple_carousel' || $el.type == 'showcase_carousel' ) {
				title = $el.title + self.svgIcons.rocketPremium;
			} else if ( $el.type == 'simple_cards' && (feedType != 'timeline' && feedType != 'events')) {
				title = self.genericText.largeGrid;
			} else if ( $el.type == 'latest_post' && (feedType == 'photos' || feedType == 'singlealbum') ) {
				title = self.genericText.singlePhoto;
			} else if ( $el.type == 'latest_post' && feedType == 'albums') {
				title = self.genericText.latestAlbum;
			} else {
				title = $el.title;
			}

			return title;
		},

		/**
		 * Feed Types Sources
		 *
		 * @since 4.0
		 */
		processFeedTypesSources : function( typesArray ){
			var self = this;
			if( self.customizerFeedData.settings.feedtype == 'timeline'){
				if( typesArray.includes('photos') ){
					self.customizerFeedData.settings.photosource = 'timeline';
				}
				if( typesArray.includes('videos') ){
					self.customizerFeedData.settings.videosource = 'timeline';
				}
				if( typesArray.includes('albums') ){
					self.customizerFeedData.settings.albumsource = 'timeline';
				}
				if( typesArray.includes('events') ){
					self.customizerFeedData.settings.eventsource = 'timeline';
				}
			}

			if( self.customizerFeedData.settings.feedtype == 'photos' ){
				self.customizerFeedData.settings.photosource = 'photospage';
			}
			if( self.customizerFeedData.settings.feedtype == 'videos' ){
				self.customizerFeedData.settings.videosource = 'videospage';
			}
			if( self.customizerFeedData.settings.feedtype == 'albums' ){
				self.customizerFeedData.settings.albumsource = 'photospage';
			}
			if( self.customizerFeedData.settings.feedtype == 'events' ){
				self.customizerFeedData.settings.eventsource = 'eventspage';
			}
		},

		/*
			Feed Creation Process
		*/
		creationProcessCheckAction : function(){
			var self = this, checkBtnNext = false;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					checkBtnNext = self.selectedFeed != null ? true : false;
					window.cffSelectedFeed = self.selectedFeed;
				break;
				case 'selectSource':
					checkBtnNext = self.selectedSources.length > 0 ? true : false;
				break;
				case 'selectTheme':
					checkBtnNext = self.selectedSources.length > 0 ? true : false;
				break;
				case 'selectTemplate':
					checkBtnNext = self.selectedSources.length > 0 ? true : false;
				break;
				case 'feedsTypeGetProcess':
					if(self.selectedFeed == 'singlealbum' && self.checkNotEmpty(self.singleAlbumFeedInfo.url)){
						checkBtnNext = true;
						if(self.singleAlbumFeedInfo.url === self.feedCreationInfoUrl && self.singleAlbumFeedInfo.isError)
							checkBtnNext = false;
						else
							self.singleAlbumFeedInfo.isError = false;

					}
					if(self.selectedFeed == 'featuredpost' && self.checkNotEmpty(self.featuredPostFeedInfo.url)){
						checkBtnNext = true;
						if(self.featuredPostFeedInfo.url === self.feedCreationInfoUrl && self.featuredPostFeedInfo.isError)
							checkBtnNext = false;
						else
							self.featuredPostFeedInfo.isError = false;
					}

					if(self.selectedFeed == 'videos' && ( self.videosTypeInfo.type == 'all' || ( self.videosTypeInfo.type == 'playlist' && self.checkNotEmpty(self.videosTypeInfo.playListUrl) ) ) ) {
						checkBtnNext = true;
						if(self.videosTypeInfo.playListUrl === self.feedCreationInfoUrl && self.videosTypeInfo.playListUrlError)
							checkBtnNext = false;
						else
							self.videosTypeInfo.playListUrlError = false;
					}
					/*
					console.log(self.checkCreationFeedTypeChosen('events_page'))
					if(self.selectedFeed === 'events' && self.checkCreationFeedTypeChosen('events_page') && self.checkNotEmpty(self.eventFeedInfo.url)){
						checkBtnNext = true;
						if(self.eventFeedInfo.url === self.feedCreationInfoUrl && self.eventFeedInfo.isError)
						checkBtnNext = false;
					else
					self.eventFeedInfo.isError = false;
				}
				*/
				break;
			}
			return checkBtnNext;
		},
		//Next Click in the Creation Process
		creationProcessNext : function(){
			var self = this;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					if(self.selectedFeed !== null){
						if (self.selectedFeed === 'socialwall') {
							window.location.href = cff_builder.pluginsInfo.social_wall.settingsPage;
							return;
						}
						self.switchScreen('selectedFeedSection', 'selectSource');
					}
				break;
				case 'selectSource':
					if(self.selectedSources.length == 0){
						self.processNotification("selectSourceError");
					}
					if(self.selectedSources.length > 0){
						if (self.hasFeature('feed_themes')) {
							self.switchScreen('selectedFeedSection', 'selectTheme');
						} else {
							self.switchScreen('selectedFeedSection', 'selectTemplate');
						}
					}
				break;
				case 'selectTheme':
					if(self.selectedSources.length == 0){
						self.processNotification("selectSourceError");
					}
					if(self.selectedSources.length > 0){
						self.switchScreen('selectedFeedSection', 'selectTemplate');
					}
				break;
				case 'selectTemplate':
					if(self.selectedSources.length > 0){
						self.switchScreen('selectedFeedSection', 'feedsTypeGetProcess');
						if(!self.extraProcessFeedsTypes.includes(self.selectedFeed) )
							self.isCreateProcessGood = true;
					}
				break;
				case 'feedsTypeGetProcess':
					//Getting Single Album Info
					if(self.selectedFeed == 'singlealbum' && self.checkNotEmpty(self.singleAlbumFeedInfo.url)){
						self.feedCreationInfoUrl = self.singleAlbumFeedInfo.url;
						self.getSingleAlbumCreationProcessInfo();
					}
					//Getting Featured Post info
					if(self.selectedFeed == 'featuredpost' && self.checkNotEmpty(self.featuredPostFeedInfo.url)){
						self.feedCreationInfoUrl = self.featuredPostFeedInfo.url;
						self.getFeaturedPostCreationProcessInfo();
					}
					//Getting PlayList Info
					if(self.selectedFeed == 'videos' && ( self.videosTypeInfo.type == 'all' || ( self.videosTypeInfo.type == 'playlist' && self.checkNotEmpty(self.videosTypeInfo.playListUrl) ) ) ){
						self.feedCreationInfoUrl = self.videosTypeInfo.playListUrl;
						if(self.videosTypeInfo.type == 'all'){
							self.submitNewFeed();
						}else{
							self.getVideosPlaylistCreationProcessInfo();
						}
					}
				break;
			}
			if(self.isCreateProcessGood){
				self.submitNewFeed();
			}


			cffBuilder.$forceUpdate();
		},
		changeVideoSource : function( videoSource ){
			this.videosTypeInfo.type = videoSource;
			cffBuilder.$forceUpdate();
		},

        //Next Click in the Onboarding Process
        onboardingNext : function(){
            this.viewsActive.onboardingStep ++;
			this.onboardingHideShow();
			cffBuilder.$forceUpdate();
		},
        //Previous Click in the Onboarding Process
        onboardingPrev : function(){
            this.viewsActive.onboardingStep --;
            this.onboardingHideShow();
			cffBuilder.$forceUpdate();
        },
		onboardingHideShow : function() {
			var tooltips = document.querySelectorAll(".sb-onboarding-tooltip");
			for (var i = 0; i < tooltips.length; i++){
				tooltips[i].style.display = "none";
			}
			document.querySelectorAll(".sb-onboarding-tooltip-"+this.viewsActive.onboardingStep)[0].style.display = "block";

			if (this.viewsActive.onboardingCustomizerPopup) {
				if (this.viewsActive.onboardingStep === 2) {
					this.switchCustomizerTab('customize');
				} else if (this.viewsActive.onboardingStep === 3) {
					this.switchCustomizerTab('settings');
				}
			}

		},
        //Close Click in the Onboarding Process
        onboardingClose : function(){
            var self = this,
				wasActive = self.viewsActive.onboardingPopup ? 'newuser' : 'customizer';

            document.getElementById("cff-builder-app").classList.remove('sb-onboarding-active');

			self.viewsActive.onboardingPopup = false;
			self.viewsActive.onboardingCustomizerPopup = false;
			this.switchCustomizerTab('customize');
			self.viewsActive.onboardingStep = 0;
            var postData = {
                action : 'cff_dismiss_onboarding',
				was_active : wasActive
			};
            self.ajaxPost(postData, function(_ref){
                var data = _ref.data;
            });
			cffBuilder.$forceUpdate();
        },
		positionOnboarding : function(){
			var self = this,
				onboardingElem = document.querySelectorAll(".sb-onboarding-overlay")[0],
				wrapElem = document.getElementById("cff-builder-app");

			if (onboardingElem === null || typeof onboardingElem === 'undefined') {
				return;
			}

			if (self.viewsActive.onboardingCustomizerPopup && self.iscustomizerScreen) {
				if (document.getElementById("sb-onboarding-tooltip-customizer-1") !== null) {
					wrapElem.classList.add('sb-onboarding-active');

					var step1El = document.querySelectorAll(".cff-csz-header")[0];
					step1El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-1"));

					var step2El = document.querySelectorAll(".sb-customizer-sidebar-sec1")[0];
					step2El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-2"));

					var step3El = document.querySelectorAll(".sb-customizer-sidebar-sec1")[0];
					step3El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-3"));

					self.onboardingHideShow();
				}
			} else if (self.viewsActive.onboardingPopup && !self.iscustomizerScreen) {
				if (cff_builder.allFeedsScreen.onboarding.type === 'single') {
					if (document.getElementById("sb-onboarding-tooltip-single-1") !== null) {
						wrapElem.classList.add('sb-onboarding-active');

						var step1El = document.querySelectorAll(".cff-fb-wlcm-header .sb-positioning-wrap")[0];
						step1El.appendChild(document.getElementById("sb-onboarding-tooltip-single-1"));

						var step2El = document.querySelectorAll(".cff-table-wrap")[0];
						if(step2El != undefined){
							step2El.appendChild(document.getElementById("sb-onboarding-tooltip-single-2"));
						}
						self.onboardingHideShow();
					}
				} else {
					if (document.getElementById("sb-onboarding-tooltip-multiple-1") !== null) {
						wrapElem.classList.add('sb-onboarding-active');

						var step1El = document.querySelectorAll(".cff-fb-wlcm-header .sb-positioning-wrap")[0];
						step1El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-1"));

						var step2El = document.querySelectorAll(".cff-fb-lgc-ctn")[0];
						step2El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-2"));

						var step3El = document.querySelectorAll(".cff-legacy-table-wrap")[0];
						step3El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-3"));

						self.activateView('legacyFeedsShown');
						self.onboardingHideShow();
					}
				}

			}
		},
		//Back Click in the Creation Process
		creationProcessBack : function(){
			var self = this;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					self.switchScreen('pageScreen', 'welcome');
					break;
				case 'selectSource':
					self.switchScreen('selectedFeedSection', 'feedsType');
					break;
				case 'selectTheme':
					self.switchScreen('selectedFeedSection', 'selectSource');
					break;
				case 'selectTemplate':
					self.switchScreen('selectedFeedSection', 'selectTheme');
					break;
				case 'feedsTypeGetProcess':
					self.switchScreen('selectedFeedSection', 'selectSource');
					break;
			}
			cffBuilder.$forceUpdate();
		},
		checkCreationFeedTypeChosen : function(feedTypeChosen){
			var self = this, isShown = false;
			switch (feedTypeChosen) {
				case "singlealbum":
					isShown = self.activeExtensions.album && (self.viewsActive.selectedFeedSection == 'feedsTypeGetProcess' && self.selectedFeed == 'singlealbum');
				break;
				case "featuredpost":
					isShown = self.activeExtensions.featured_post && (self.viewsActive.selectedFeedSection == 'feedsTypeGetProcess' && self.selectedFeed == 'featuredpost');
				break;
				case "videos":
					isShown = (self.viewsActive.selectedFeedSection == 'feedsTypeGetProcess' && self.selectedFeed == 'videos');
				break;
				/*
				case "events_page":
					let onlyPageSources = self.sourcesList.map( source => {
						if(source.account_type === 'page' )
						return source.account_id;
				});
				delete onlyPageSources[undefined];
				let isPage = self.selectedSources.filter(
					sourceID => onlyPageSources.includes(sourceID)
					);
					isShown = (self.viewsActive.selectedFeedSection == 'feedsTypeGetProcess' && self.selectedFeed == 'events' && isPage.length > 0);
					break;
					*/
				}
			return isShown;
		},
		//Get Single Album info in the creation Process
		getSingleAlbumCreationProcessInfo : function(){
			var self = this;
			var singleAlbumData = {
				action : 'cff_source_get_featured_post_preview',
				url_or_id : self.singleAlbumFeedInfo.url,
				source_id : self.selectedSources[0],
                feed_type : 'album'
			};
			self.ajaxPost(singleAlbumData, function(_ref){
				var data = _ref.data;
				if(self.hasOwnNestedProperty(data,'error')){
					self.singleAlbumFeedInfo.isError = true, self.singleAlbumFeedInfo.success = false, self.singleAlbumFeedInfo.info = {};
				}else {
					self.singleAlbumFeedInfo.isError = false,self.singleAlbumFeedInfo.success = true;
					var albumID = data.id.split("_");
					albumID = albumID[1] != undefined ? albumID[1] : data.id;

                    if( data?.attachments?.data[0] ){
                        self.singleAlbumFeedInfo.info = {
                            title : data.attachments.data[0].title ? data.attachments.data[0].title : '',
                            description : data.story ? data.story : '',
                            thumbnail : self.hasOwnNestedProperty(data,'full_picture') ? data.full_picture : '',
                            album : albumID
                        };
                    }else if( data?.cover_photo?.source ){
                         self.singleAlbumFeedInfo.info = {
                            title : data?.name ? data.name : '',
                            description : data?.story ? data.story : '',
                            thumbnail : data?.cover_photo?.source ? data?.cover_photo?.source : '',
                            album : albumID
                        };
                    }
					self.isCreateProcessGood = true;
				}
			});
		},
		//Get Videos Play List Info
		getVideosPlaylistCreationProcessInfo : function(){
			var self = this,
			videosPlaylistData = {
				action : 'cff_source_get_playlist_post_preview',
				url_or_id : self.videosTypeInfo.playListUrl,
				source_id : self.selectedSources[0]
			};
			self.ajaxPost(videosPlaylistData, function(_ref){
				var data = _ref.data;
				if(self.hasOwnNestedProperty(data,'error')){
					self.videosTypeInfo.playListUrlError = true, self.videosTypeInfo.success = false;
				}else {
					self.videosTypeInfo.info = {
						playlistID : data.playlistID
					}
					self.videosTypeInfo.playListUrlError = false, self.videosTypeInfo.success = true;
					self.isCreateProcessGood = true;
					self.submitNewFeed();
				}
			});

		},

		//Get Featured Post info in the creation Process
		getFeaturedPostCreationProcessInfo : function(){
			var self = this;
			var featuredPostData = {
				action : 'cff_source_get_featured_post_preview',
				url_or_id : self.featuredPostFeedInfo.url,
				source_id : self.selectedSources[0]
			};
			self.ajaxPost(featuredPostData, function(_ref){
				var data = _ref.data;
				if(self.hasOwnNestedProperty(data,'error')){
					self.featuredPostFeedInfo.isError = true, self.featuredPostFeedInfo.success = false, self.featuredPostFeedInfo.info = {};
				}else {
					self.featuredPostFeedInfo.isError = false,self.featuredPostFeedInfo.success = true;
					self.featuredPostFeedInfo.info = {
						description : data.message ? data.message.substr(0, 60) + '...' : '',
						thumbnail : self.hasOwnNestedProperty(data,'full_picture') ? data.full_picture : '',
						featuredpost : data.id
					};
					self.isCreateProcessGood = true;
				}
			});
		},
		//Get Events iCal URL
		getEventsIcalURLCreationProcessInfo : function(){
			var self = this;
			var eventFeedData = {
				action : 'cff_feed_saver_manager_check_events_ical_url',
				ical_url : self.eventFeedInfo.url,
				source_id : self.selectedSources[0]
			};
			self.ajaxPost(eventFeedData, function(_ref){
				var data = _ref.data.data;
				if(self.hasOwnNestedProperty(data,'error')){
					self.eventFeedInfo.isError = true, self.eventFeedInfo.success = false, self.eventFeedInfo.info = {};
				}else {
					self.eventFeedInfo.isError = false,self.eventFeedInfo.success = true;
					self.eventFeedInfo.info = {
						description : data.message ? data.message.substr(0, 60) + '...' : ''
					};
					self.isCreateProcessGood = true;
				}
			});
		},
		getSelectedSourceName : function(sourceID){
			var self = this;
			var sourceInfo = self.sourcesList.filter(function(source){
				return source.account_id == sourceID;
			});
			return (sourceInfo.length > 0) ? sourceInfo[0].username : '';
		},
		//Create & Submit New Feed
		submitNewFeed : function(){
			var self = this,
			newFeedData = {
				action : 'cff_feed_saver_manager_builder_update',
				sources : self.selectedSources,
				new_insert : 'true',
				sourcename : self.getSelectedSourceName(self.selectedSources[0]),
				feedtype : self.selectedFeed,
				feedtemplate : self.selectedFeedTemplate,
				feedtheme: self.selectedFeedTheme,
				type : self.type
			};
			if(self.selectedFeed == 'featuredpost'){
				newFeedData.featuredpost = self.featuredPostFeedInfo.info.featuredpost;
			}
			if(self.selectedFeed == 'singlealbum'){
				newFeedData.album = self.singleAlbumFeedInfo.info.album;
			}
			if(self.selectedFeed == 'videos'){
				newFeedData.playlist = (self.videosTypeInfo.info.playlistID != undefined && self.videosTypeInfo.type == 'playlist') ? self.videosTypeInfo.info.playlistID : '';
			}
			if(self.selectedFeed == 'events' && self.checkCreationFeedTypeChosen('events_page') ){
				newFeedData.ical_url = self.eventFeedInfo.url;
			}
			self.fullScreenLoader = true;

			self.ajaxPost(newFeedData, function(_ref){
				var data = _ref.data;
				if(data.feed_id && data.success){
					window.location = self.builderUrl + '&feed_id=' + data.feed_id + self.sw_feed_params();
				}
			});
		},

		sw_feed_params: function() {
			let sw_feed_param = '';
			if ( this.sw_feed ) {
				sw_feed_param += '&sw-feed=true';
			}
			if ( this.sw_feed_id ) {
				sw_feed_param += '&sw-feed-id=' + this.sw_feed_id;
			}
			return sw_feed_param;
		},

		swfeedReturnUrl: function() {
			var self = this;
			if ( self.sw_feed ) {
				sw_return_url = 'admin.php?page=sbsw#/create-feed'
			}
			if ( self.sw_feed_id ) {
				sw_return_url = 'admin.php?page=sbsw&feed_id=' + self.sw_feed_id
			}
			return sw_return_url;
		},

		//Source Ative
		isSourceSelectActive : function(source){
			if(this.selectedSources.includes(source.account_id)){
				return (this.selectedFeed == 'events' && (source.privilege == 'events' || source.account_type == 'group')) || (this.selectedFeed != 'events' && source.privilege != 'events');
			}
			return false;
		},

		//Source Ative
		isSourceSelectActivePopup : function(source){
			if(this.selectedSources.includes(source.account_id)){
				return (this.customizerFeedData.settings.feedtype == 'events' && source.privilege == 'events') || (this.customizerFeedData.settings.feedtype != 'events' && source.privilege != 'events');
			}
			return false;
		},

		//Select & Choose the Feed Source Popup
		checkSourceForEventsPopup : function(source){
			return this.customizerFeedData.settings.feedtype == 'events' && source.account_type == 'page' && source.privilege != 'events';
		},

		checkTypeForGroupPopup : function(source){
			return source.account_type === 'group' && this.customizerFeedData.settings.feedtype === 'photos';
		},

		//Select & Choose the Feed Source
		checkSourceForEvents : function(source){
			return this.selectedFeed == 'events' && source.account_type == 'page' && source.privilege != 'events';
		},
		checkTypeForGroup : function(source){
			return source.account_type === 'group' && this.selectedFeed === 'photos';
		},
		selectSource : function(source){
			var self = this;
			isMultifeed = (self.activeExtensions['multifeed'] !== undefined  && self.activeExtensions['multifeed'] == true);
			if(!self.checkSourceForEvents(source) && !self.checkTypeForGroup(source)){
				if(isMultifeed){
					if(self.selectedSources.includes(source.account_id)){
						self.selectedSources.splice(self.selectedSources.indexOf(source.account_id), 1);
					}else{
						self.selectedSources.push(source.account_id);
					}
				}else{
					self.selectedSources = (self.selectedSources.includes(source.account_id)) ? [] : [source.account_id];
				}
			}
		},
		processDomList : function(selector, attributes){
			document.querySelectorAll(selector).forEach( function(element) {
				attributes.map( function(attrName) {
					element.setAttribute(attrName[0], attrName[1]);
				});
			});
		},
		openTooltipBig : function(){
			var self = this, elem = window.event.currentTarget;
			self.processDomList('.cff-fb-onbrd-tltp-elem', [['data-active', 'false']]);
			elem.querySelector('.cff-fb-onbrd-tltp-elem').setAttribute('data-active', 'true');
			cffBuilder.$forceUpdate();
		},
		closeTooltipBig : function(){
			var self = this;
			self.processDomList('.cff-fb-onbrd-tltp-elem', [['data-active', 'false']]);
			window.event.stopPropagation();
			cffBuilder.$forceUpdate();
		},

		/*
			FEEDS List Actions
		*/

		/**
		 * Switch Bulk Action
		 *
		 * @since 4.0
		 */
		bulkActionClick : function(){
			var self = this;
			switch (self.selectedBulkAction) {
				case 'delete':
					if(self.feedsSelected.length > 0){
						self.openDialogBox('deleteMultipleFeeds')
					}
				break;
			}
			cffBuilder.$forceUpdate();
		},

		/**
		 * Duplicate Feed
		 *
		 * @since 4.0
		 */
		feedActionDuplicate : function(feed){
			var self = this,
			feedsDuplicateData = {
				action : 'cff_feed_saver_manager_duplicate_feed',
				feed_id : feed.id
			};
			self.ajaxPost(feedsDuplicateData, function(_ref){
				var data = _ref.data;
				self.feedsList = Object.values(Object.assign({}, data));
				//self.feedsList = data;
			});
			cffBuilder.$forceUpdate();
		},

		/**
		 * Delete Feed
		 *
		 * @since 4.0
		 */
		feedActionDelete : function(feeds_ids){
			var self = this,
			feedsDeleteData = {
				action : 'cff_feed_saver_manager_delete_feeds',
				feeds_ids : feeds_ids
			};
			self.ajaxPost(feedsDeleteData, function(_ref){
				var data = _ref.data;
				self.feedsList = Object.values(Object.assign({}, data));
				self.feedsSelected = [];
			});
		},

		/**
		 * View Feed Instances
		 *
		 * @since 4.0
		 */
		viewFeedInstances : function(feed){
			var self = this;
			self.viewsActive.instanceFeedActive = feed;
			self.movePopUp();
			cffBuilder.$forceUpdate();
		},

		/**
		 * Select All Feeds in List
		 *
		 * @since 4.0
		 */
		selectAllFeedCheckBox : function(){
			var self = this;
			if( !self.checkAllFeedsActive() ){
				self.feedsSelected = [];
				self.feedsList.forEach( function(feed) {
					self.feedsSelected.push(feed.id);
				});
			}else{
				self.feedsSelected = [];
			}

		},

		/**
		 * Select Single Feed in List
		 *
		 * @since 4.0
		 */
		selectFeedCheckBox : function(feedID){
			if(this.feedsSelected.includes(feedID)){
				this.feedsSelected.splice(this.feedsSelected.indexOf(feedID),1);
			}else{
				this.feedsSelected.push(feedID);
			}
			cffBuilder.$forceUpdate();
		},

		/**
		 * Check if All Feeds are Selected
		 *
		 * @since 4.0
		 */
		checkAllFeedsActive : function(){
			var self = this,
			result = true;
			self.feedsList.forEach( function(feed) {
				if(!self.feedsSelected.includes(feed.id)){
					result = false;
				}
			});

			return result;
		},

		feedThemeAction: function() {
			var self = this;
			if (self.hasFeature('feed_themes')) {
				self.activateView('feedthemePopup');
			} else {
				// self.activateView('postSettings');
				self.viewsActive.extensionsPopupElement = 'feedThemes'
			}
		},


		/**
		 * Copy text to clipboard
		 *
		 * @since 4.0
		 */
		copyToClipBoard : function(value){
			var self = this;
			const el = document.createElement('textarea');
			el.className = 'cff-fb-cp-clpboard';
			el.value = value;
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
			self.notificationElement =  {
				type : 'success',
				text : this.genericText.copiedClipboard,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 3000);
			cffBuilder.$forceUpdate();
		},


		/**
		 * Check Post Show
		 *
		 * @since 4.0
		 */
		shouldShowPostList : function(layout, singlePost){
			var self = this;
			return self.customizerFeedData.settings.layout == layout &&
			(
				(
					self.customizerFeedData.settings.feedtype == 'reviews' &&
					((self.valueIsEnabled(self.customizerFeedData.settings.hidenegative) && singlePost.recommendation_type == 'positive') || !self.valueIsEnabled(self.customizerFeedData.settings.hidenegative) )
				)
				|| self.customizerFeedData.settings.feedtype != 'reviews'
			)
		},



		/*-------------------------------------------
			CUSTOMIZER FUNCTIONS
		-------------------------------------------*/
		/**
		 * HighLight Section
		 *
		 * @since 4.0
		 */
		isSectionHighLighted : function(sectionName){
			var self = this;
			return (self.highLightedSection === sectionName ||  self.highLightedSection === 'all')
 		},

 		/**
		 * Enable HightLight Section
		 *
		 * @since 4.0
		 */
 		enableHighLightSection : function(sectionId){
			var self = this,
				listPostSection = ['customize_feedlayout', 'customize_colorscheme', 'customize_posts','post_style','individual_elements'],
				headerSection = ['customize_header'],
				likeBoxSection = ['customize_likebox'],
				loadeMoreSection = ['customize_loadmorebutton'],
				lightBoxSection = ['customize_lightbox'],
				domBody = document.getElementsByTagName("body")[0];

			self.dummyLightBoxData.visibility = 'hidden';
			domBody.classList.remove("no-overflow");

			if( listPostSection.includes(sectionId) ){
				self.highLightedSection = 'postList';
				self.scrollToHighLightedSection("cff-post-list-section");
			}else if( headerSection.includes(sectionId) ){
				self.highLightedSection = 'header';
				self.scrollToHighLightedSection("cff-header-section");
			}else if( likeBoxSection.includes(sectionId) ){
				self.highLightedSection = 'likeBox';
				self.scrollToHighLightedSection("cff-like-box-section");
			}else if( loadeMoreSection.includes(sectionId) ){
				self.highLightedSection = 'loadMore';
				self.scrollToHighLightedSection("cff-load-more-section");
			}else if( lightBoxSection.includes(sectionId) ){
				self.highLightedSection = 'lightBox';
				self.dummyLightBoxData.visibility = 'shown';
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
				domBody.classList.add("no-overflow");
			}else{
				self.highLightedSection = 'all';
				self.dummyLightBoxData.visibility = 'hidden';
				domBody.classList.remove("no-overflow");
			}
 		},


 		/**
		 * Scroll to Highlighted Section
		 *
		 * @since 4.0
		 */
 		scrollToHighLightedSection : function(sectionId){
			const element = document.getElementById(sectionId);
			if(element != undefined && element != null){
				const y = element.getBoundingClientRect().top - 100 + window.pageYOffset - 10;
				window.scrollTo({top: y, behavior: 'smooth'});
			}
 		},

 		/**
		 * Enable & Show Color Picker
		 *
		 * @since 4.0
		 */
 		showColorPickerPospup : function(controlId){
			this.customizerScreens.activeColorPicker = controlId;
 		},

 		/**
		 * Hide Color Picker
		 *
		 * @since 4.0
		 */
 		hideColorPickerPospup : function(){
			this.customizerScreens.activeColorPicker = null;
 		},

		switchCustomizerPreviewDevice : function(previewScreen){
			var self = this;
			self.customizerScreens.previewScreen = previewScreen;
			self.loadingBar = true;
			self.reinitCarouselHTML();
			setTimeout(function(){
				self.generateMasonryGridHeight('update');
				self.loadingBar = false;
			},200)
			cffBuilder.$forceUpdate();
		},
		switchCustomizerTab : function(tabId){
			var self = this,
				domBody = document.getElementsByTagName("body")[0];
			self.customizerScreens.activeTab = tabId;
			self.customizerScreens.activeSection = null;
			self.customizerScreens.activeSectionData = null;
			self.highLightedSection = 'all';

			self.dummyLightBoxData.visibility = 'hidden';
			domBody.classList.remove("no-overflow");
			cffBuilder.$forceUpdate();
		},
		switchCustomizerSection : function(sectionId, section, isNested = false, isBackElements){
			var self = this;
			self.customizerScreens.parentActiveSection = null;
			self.customizerScreens.parentActiveSectionData = null;
			if(isNested){
				self.customizerScreens.parentActiveSection = self.customizerScreens.activeSection;
				self.customizerScreens.parentActiveSectionData = self.customizerScreens.activeSectionData;
			}
			self.customizerScreens.activeSection = sectionId;
			self.customizerScreens.activeSectionData = section;
			self.enableHighLightSection(sectionId);
			cffBuilder.$forceUpdate();
		},
		switchNestedSection : function(sectionId, section){
			var self = this;
			if(section !== null){
				self.customizerScreens.activeSection = sectionId;
				self.customizerScreens.activeSectionData = section;
			}else{
				var sectionArray = sectionId['sections'];
				var elementSectionData = self.customizerSidebarBuilder;

				sectionArray.map(function(elm, index){
					elementSectionData = (elementSectionData[elm] != undefined && elementSectionData[elm] != null) ? elementSectionData[elm] : null;
				});
				if(elementSectionData != null){
					self.customizerScreens.activeSection = sectionId['id'];
					self.customizerScreens.activeSectionData = elementSectionData;
				}
			}
			cffBuilder.$forceUpdate();
		},
		backToPostElements : function(){
			var self = this,
				individual_elements = self.customizerSidebarBuilder['customize'].sections.customize_posts.nested_sections.individual_elements;
				self.customizerScreens.activeSection = 'customize_posts';
				self.customizerScreens.activeSectionData= self.customizerSidebarBuilder['customize'].sections.customize_posts;
				self.switchCustomizerSection('individual_elements', individual_elements, true, true);
				cffBuilder.$forceUpdate();
		},

		processDateRange : function(){
			var self = this,
				settings = self.customizerFeedData.settings;
			if(settings['daterangefromtype'] == 'relative'){
				self.customizerFeedData.settings['from'] = settings['daterangefromrelative'];
			}else{
				self.customizerFeedData.settings['from'] = settings['daterangefromspecific'];
			}

			if(settings['daterangeuntiltype'] == 'relative'){
				self.customizerFeedData.settings['until'] = settings['daterangeuntilrelative'];
			}else{
				self.customizerFeedData.settings['until'] = settings['daterangeuntilspecific'];
			}

			self.customizerControlAjaxAction('feedFlyPreview');
		},

		changeSettingValue : function(settingID, value, doProcess = true, ajaxAction = false) {
			var self = this,
				dateRangeElements = [
					'daterangefromtype',
					'daterangefromspecific',
					'daterangefromrelative',
					'daterangeuntiltype',
					'daterangeuntilspecific',
					'daterangeuntilrelative'
				];
			if( dateRangeElements.includes(settingID) ){
				self.processDateRange();
			}
			if(settingID == 'feedlayout'  && value == 'masonry'){
				self.customizerFeedData.settings['layout'] = 'full';
			}

			if(settingID == 'feedlayout' && value == 'carousel' && !self.checkExtensionActive('carousel')){
				self.viewsActive.extensionsPopupElement = 'carousel';
			}else{
				if(doProcess){
					self.customizerFeedData.settings[settingID] = value;
				}
				if(settingID === 'showpoststypes' && value === 'all'){
					ajaxAction = 'feedFlyPreview';
					self.customizerFeedData.settings.type = [
						'links',
						'events',
						'videos',
						'photos',
						'albums',
						'statuses'
					];
				}
				if(ajaxAction !== false){
					self.customizerControlAjaxAction(ajaxAction);
				}
				var whenToGenerateFeed = [
						'layout',
						'feedlayout',
						'cols',
						'colstablet',
						'colsmobile'
					];
				if( whenToGenerateFeed.includes( settingID ) ){
					self.loadingBar = true;
					self.generateMasonryGridHeight('update');
					self.reinitCarouselHTML();
					setTimeout(function(){
						self.processNotification('previewUpdated');
					}, 1000)
				}
				self.checkReinitCarousel(settingID);
			}

		},


		changeSwitcherSettingValue : function(settingID, onValue, offValue, ajaxAction = false) {
			var self = this;
			self.customizerFeedData.settings[settingID] = self.customizerFeedData.settings[settingID] == onValue ? offValue : onValue;
			if(ajaxAction !== false){
				self.customizerControlAjaxAction(ajaxAction);
			}
			self.checkReinitCarousel(settingID);
		},

		changeCheckboxSectionValue : function(settingID, value, ajaxAction = false){
			var self = this;
			var settingValue = self.customizerFeedData.settings[settingID];
			if( !Array.isArray(settingValue) && settingID == 'include'){
				settingValue = settingValue.split(',');
			}

			if(!Array.isArray(settingValue) && settingID == 'type'){
				settingValue = [settingValue];
			}
			if(settingValue.includes(value)){
				settingValue.splice(settingValue.indexOf(value),1);
			}else{
				settingValue.push(value);
			}
			if(settingID == 'type'){
				self.processFeedTypesSources( settingValue );
			}
			//settingValue = (settingValue.length == 1 && settingID == 'type') ? settingValue[0] : settingValue;
			self.customizerFeedData.settings[settingID] = settingValue;
			if(ajaxAction !== false){
				self.customizerControlAjaxAction(ajaxAction);
			}
			if(settingID == 'include'){
				setTimeout(function(){
					self.generateMasonryGridHeight('update');
				},250);
			}
			event.stopPropagation()

		},
		checkboxSectionValueExists : function(settingID, value){
			var self = this;
			var settingValue = self.customizerFeedData.settings[settingID];
			return settingValue.includes(value) ? true : false;
		},

		/**
		 * Check Control Condition
		 *
		 * @since 4.0
		*/
		checkControlCondition : function(conditionsArray = [], checkExtensionActive = false, checkExtensionActiveDimmed = false){
			var self = this,
			isConditionTrue = 0;
			Object.keys(conditionsArray).forEach(function(condition, index){
				if(conditionsArray[condition].indexOf(self.customizerFeedData.settings[condition]) !== -1)
					isConditionTrue += 1
			});
			var extensionCondition = checkExtensionActive != undefined && checkExtensionActive != false ? self.checkExtensionActive(checkExtensionActive) : true,
				extensionCondition = checkExtensionActiveDimmed != undefined && checkExtensionActiveDimmed != false && !self.checkExtensionActive(checkExtensionActiveDimmed) ? false : extensionCondition;

			return (isConditionTrue == Object.keys(conditionsArray).length) ? ( extensionCondition ) : false;
		},

		/**
		 * Check Color Override Condition
		 *
		 * @since 4.0
		*/
		checkControlOverrideColor : function(overrideConditionsArray = []){
			var self = this,
			isConditionTrue = 0;
			overrideConditionsArray.forEach(function(condition, index){
				if(self.checkNotEmpty(self.customizerFeedData.settings[condition]) && self.customizerFeedData.settings[condition].replace(/ /gi,'') != '#'){
					isConditionTrue += 1
				}
			});
			return (isConditionTrue >= 1) ? true : false;
		},

		/**
		 * Show Control
		 *
		 * @since 4.0
		*/
		isControlShown : function( control ){
			var self = this;
			if(control.checkExtension != undefined && control.checkExtension != false && !self.checkExtensionActive(control.checkExtension)){
				return self.checkExtensionActive(control.checkExtension);
			}

			if(control.conditionDimmed != undefined && self.checkControlCondition(control.conditionDimmed) )
				return self.checkControlCondition(control.conditionDimmed);
			if(control.overrideColorCondition != undefined){
				return self.checkControlOverrideColor( control.overrideColorCondition );
			}

			return ( control.conditionHide != undefined && control.condition != undefined || control.checkExtension != undefined )
				? self.checkControlCondition(control.condition, control.checkExtension)
				: true;
		},

		checkExtensionActive : function(extension){
			var self = this;
			return self.activeExtensions[extension];
		},

		expandSourceInfo : function(sourceId){
			var self = this;
			self.customizerScreens.sourceExpanded = (self.customizerScreens.sourceExpanded === sourceId) ? null : sourceId;
			window.event.stopPropagation()
		},

		resetColor: function(controlId){
			this.customizerFeedData.settings[controlId] = '';
		},

		//Source Active Customizer
		isSourceActiveCustomizer : function(source){
			var self = this;
			return (
						Array.isArray(self.customizerFeedData.settings.sources.map) ||
						self.customizerFeedData.settings.sources instanceof Object
					) &&
				self.customizerScreens.sourcesChoosed.map(s => s.account_id).includes(source.account_id);
				//self.customizerFeedData.settings.sources.map(s => s.account_id).includes(source.account_id);
		},
		//Choose Source From Customizer
		selectSourceCustomizer : function(source, isRemove = false){
			var self = this,
			isMultifeed = (self.activeExtensions['multifeed'] !== undefined  && self.activeExtensions['multifeed'] == true),
			sourcesListMap = Array.isArray(self.customizerFeedData.settings.sources) || self.customizerFeedData.settings.sources instanceof Object ? self.customizerFeedData.settings.sources.map(s => s.account_id) : [];
			if((self.customizerFeedData.settings.feedtype == 'events' && (source.privilege == 'events' || source.account_type == 'group')) || (self.customizerFeedData.settings.feedtype != 'events')){
				if(isMultifeed){
					if(self.customizerScreens.sourcesChoosed.map(s => s.account_id).includes(source.account_id)){
						var indexToRemove = self.customizerScreens.sourcesChoosed.findIndex(src => src.account_id === source.account_id);
						self.customizerScreens.sourcesChoosed.splice(indexToRemove, 1);
						if(isRemove){
							self.customizerFeedData.settings.sources.splice(indexToRemove, 1);
						}
					}else{
						self.customizerScreens.sourcesChoosed.push(source);
					}
				}else{
					self.customizerScreens.sourcesChoosed = (sourcesListMap.includes(source)) ? [] : [source];
				}
			}
			cffBuilder.$forceUpdate();
		},
		closeSourceCustomizer : function(){
			var self = this;
			self.viewsActive['sourcePopup'] = false;
			//self.customizerFeedData.settings.sources = self.customizerScreens.sourcesChoosed;
			cffBuilder.$forceUpdate();
		},
		customizerFeedTemplatePrint : function(){
			var self = this;
			// Support for versions before v4.2
			if ( self.customizerFeedData.settings.feedtemplate == undefined ) {
				self.customizerFeedData.settings.feedtemplate = 'default';
			}
			result = self.feedTemplates.filter(function(tp){
				return tp.type === self.customizerFeedData.settings.feedtemplate
			});
			self.customizerScreens.printedTemplate = result.length > 0 ? result[0] : [];
			return result.length > 0 ? true : false;
		},
		customizerFeedThemePrint : function(){
			var self = this;
			// Support for versions before v4.2
			if ( self.customizerFeedData.settings.feedtheme == undefined ) {
				self.customizerFeedData.settings.feedtheme = 'default_theme';
			}
			result = self.feedThemes.filter(function(tp){
				return tp.type === self.customizerFeedData.settings.feedtheme
			});
			self.customizerScreens.printedTheme = result.length > 0 ? result[0] : [];
			return result.length > 0 ? true : false;
		},
		customizerFeedTypePrint : function(){
			var self = this,
			combinedTypes = self.feedTypes.concat(self.advancedFeedTypes);
			result = combinedTypes.filter(function(tp){
				return tp.type === self.customizerFeedData.settings.feedtype
			});
			self.customizerScreens.printedType = result.length > 0 ? result[0] : [];
			return result.length > 0 ? true : false;
		},
		choosedFeedTypeCustomizer : function(feedType){
			var self = this, result = false;
			if(
				(self.viewsActive.feedTypeElement === null && self.customizerFeedData.settings.feedtype === feedType) ||
				(self.viewsActive.feedTypeElement !== null && self.viewsActive.feedTypeElement == feedType)
			){
				result = true;
			}
			return result;
		},
		choosedFeedTemplateCustomizer : function(feedtemplate){
			var self = this, result = false;
			if(
				(self.viewsActive.feedTemplateElement === null && self.customizerFeedData.settings.feedtemplate === feedtemplate) ||
				(self.viewsActive.feedTemplateElement !== null && self.viewsActive.feedTemplateElement == feedtemplate)
			){
				result = true;
			}
			return result;
		},
		updateFeedTypeCustomizer : function(){
			var self = this;
			if (self.viewsActive.feedTypeElement === 'socialwall') {
				window.location.href = cff_builder.pluginsInfo.social_wall.settingsPage;
				return;
			}
            if (self.viewsActive.feedTypeElement !== 'featuredpost' && self.checkNotEmpty(self.customizerFeedData.settings.featuredpost)) {
                self.customizerFeedData.settings.featuredpost = '';
            }
			self.setType( self.viewsActive.feedTypeElement );

			self.customizerFeedData.settings.feedtype = self.viewsActive.feedTypeElement;
			self.viewsActive.feedTypeElement = null;
			self.viewsActive.feedtypesPopup = false;
			self.customizerControlAjaxAction('feedFlyPreview');
			cffBuilder.$forceUpdate();
		},
		updateFeedTemplateCustomizer : function(){
			var self = this;

			self.customizerFeedData.settings.feedtemplate = self.viewsActive.feedTemplateElement;
			self.viewsActive.feedTemplateElement = null;
			self.viewsActive.feedtemplatesPopup = false;
			self.customizerControlAjaxAction('feedTemplateFlyPreview');
			cffBuilder.$forceUpdate();
		},
		updateFeedThemeCustomizer : function(feedTheme){
			var self = this;
			self.customizerFeedData.settings.feedtheme = feedTheme;
			// self.customizerControlAjaxAction('feedThemeFlyPreview');
			cffBuilder.$forceUpdate();
		},
		updateInputWidth : function(){
			this.customizerScreens.inputNameWidth = ((document.getElementById("cff-csz-hd-input").value.length + 6) * 8) + 'px';
		},
		customizerStyleMaker : function(){
			var self = this;
			if(self.customizerSidebarBuilder){
				self.feedStyle = '';
				 Object.values(self.customizerSidebarBuilder).map( function(tab) {
				 	self.customizerSectionStyle(tab.sections);
				});
				return '<style type="text/css">' + self.feedStyle + '</style>';
			}
			return false;
		},

		/**
		 * Get Feed Preview Global CSS Class
		 *
		 * @since 4.0
		 * @return String
		 */
		feedPreviewCssClasses : function(){
			var self = this,
				colorScheme = self.customizerFeedData.settings.colorpalette;

		},

		customizerSectionStyle : function(sections){
			var self = this;
			Object.values(sections).map(function(section){
				if(section.controls){
					Object.values(section.controls).map(function(control){
						self.returnControlStyle(control);
					});
				}
				if(section.nested_sections){
			 		self.customizerSectionStyle(section.nested_sections);
			 		Object.values(section.nested_sections).map(function(nestedSections){
			 			Object.values(nestedSections.controls).map(function(nestedControl){
				 			if(nestedControl.section){
			 					self.customizerSectionStyle(nestedControl);
				 			}
						});
			 		});
				}
			});
		},
		returnControlStyle : function( control ){
			var self = this;
			if(control.style){
				Object.entries(control.style).map( function(css) {
					var condition = control.condition != undefined || control.checkExtension != undefined ? self.checkControlCondition(control.condition, control.checkExtension) : true;
					if( condition ){
						self.feedStyle +=
							css[0] + '{' +
								css[1].replace("{{value}}", self.customizerFeedData.settings[control.id]) +
							'}';
					}
				});
			}
		},

		/**
		 * Check Reinit Carousel
		 *
		 * @since 4.0
		*/
		checkReinitCarousel : function(settingID){
			var self = this,
				whenToReiniCarousel = [
					'carouselheight',
					'carouseldesktop_cols',
					'carouselmobile_cols',
					'carouselnavigation',
					'carouselpagination',
					'carouselautoplay',
					'carouselinterval',
					'reviewshidenotext',
					'hidenegative',
					'reviewsrated'
				];
			if( whenToReiniCarousel.includes( settingID ) ){
				self.reinitCarouselHTML();
			}
		},


		/**
		 * Customizer Control Ajax
		 * Some of the customizer controls need to perform Ajax
		 * Calls in order to update the preview
		 *
		 * @since 4.0
		 */
		customizerControlAjaxAction : function( actionType ){
			var self = this;
			switch (actionType) {
				case 'feedFlyPreview':
					self.loadingBar = true;
					var previewFeedData = {
						action : 'cff_feed_saver_manager_fly_preview',
						feedID : self.customizerFeedData.feed_info.id,
						previewSettings : self.customizerFeedData.settings,
					};
                    self.ajaxPost(previewFeedData, function(_ref){
						var data = _ref.data;
						if( data !== false ){
							self.disableJQueryNodes();
							self.customizerFeedData.posts = data.posts;
							self.customizerFeedData.header = data.header;
							self.processNotification("previewUpdated");
						}else{
							self.processNotification("unkownError");
						}
						setTimeout(function(){
							self.reinitCarouselHTML();
							self.generateMasonryGridHeight('update');
						}, 150);
					});
				break;
				case 'feedTemplateFlyPreview':
					self.loadingBar = true;
					var previewFeedData = {
						action : 'cff_feed_saver_manager_fly_preview',
						feedID : self.customizerFeedData.feed_info.id,
						previewSettings : self.customizerFeedData.settings,
						isFeedTemplatesPopup : true,
					};
					self.ajaxPost(previewFeedData, function(_ref){
						var data = _ref.data;
						if( data !== false ){
							self.customizerFeedData.settings = data.customizerData;
							self.disableJQueryNodes();
							self.customizerFeedData.posts = data.posts;
							self.customizerFeedData.header = data.header;
							self.processNotification("previewUpdated");
						}else{
							self.processNotification("unkownError");
						}
						setTimeout(function(){
							self.reinitCarouselHTML();
							self.generateMasonryGridHeight('update');
						}, 150);
					});
				break;
				case 'feedPreviewRender':
					setTimeout(function(){
						self.generateMasonryGridHeight('update');
					}, 150);
				break;
			}
		},

		/**
		 * Process & Re-Order Post Array for Masonry layouts
		 *
		 * @since 4.0
		 *
		 * @return Array
		 */
		processPostArrayDisplay : function(postsArray){
			var self 		  = this,
				feedlayout 	  = self.customizerFeedData.settings.feedlayout,
				feedtype 	  =	self.customizerFeedData.settings.feedtype,
				currentDevice = self.customizerScreens.previewScreen;
			if(feedlayout === 'masonry'){
				var colsNumber = 1;
 				switch (currentDevice) {
 					case 'desktop':
 						colsNumber = self.customizerFeedData.settings.cols;
					break;
					case 'tablet':
 						colsNumber = self.customizerFeedData.settings.colstablet;
					break;
					case 'mobile':
 						colsNumber = self.customizerFeedData.settings.colsmobile;
					break;
 				}
 				colsNumber = parseInt(colsNumber);
 				if(colsNumber > 1){
 					var reorderedPostsArray = [],
 						counter = 0;
 					while(counter < colsNumber) {
 						for(var i = 0; i < postsArray.length; i += colsNumber) {
 							var elementIndex = parseInt(i) + parseInt(counter);
 							var _val = postsArray[elementIndex];
 							if (_val !== undefined)
 								reorderedPostsArray.push(_val);
 						}
 						counter++;
 					}
 					postsArray = reorderedPostsArray;
 				}
 			}
			return postsArray;
		},

		/**
		 * Generate the Feed Posts Height For Masonry & Grid Layouts
		 *
		 * @since 4.0
		 */
		generateCarouselSettings : function(){
			var self 		  = this,
				carouselElement = jQuery('.cff-preview-posts-list-ctn'),
				customizerSettings = self.customizerFeedData.settings,
				currentDevice = self.customizerScreens.previewScreen;
				self.disableJQueryNodes();
			if(customizerSettings.feedlayout === 'carousel' && self.activeExtensions['carousel'] == true){
				carouselElement.addClass('cff-carousel');
				var carouselHeightInput = customizerSettings.carouselheight,
	            	carouselMobileCols = parseInt(customizerSettings.carouselmobile_cols),
	            	carouselCols = (currentDevice == 'desktop') ? parseInt(customizerSettings.carouseldesktop_cols) : carouselMobileCols,
	            	carouselArrowsInput = parseInt(customizerSettings.carouselnavigation),
	            	carouselArrows = true,
	            	carouselPag = self.valueIsEnabled(customizerSettings.carouselpagination) ? true : false,
	            	carouselautoplay = self.valueIsEnabled(customizerSettings.carouselautoplay) ? true : false,
	            	carouselTime = customizerSettings.carouselinterval,
	            	afterUpdate = true;
	            	afterInit = false,
	            	singleItem = false,
	            	autoHeight = false;
	            	if(customizerSettings.carouselheight == 'autoexpand'){
	            		singleItem = true;
	            		autoHeight = true;
	            		carouselCols = 1;
						carouselMobileCols = 1;
	            	}

	            	if(customizerSettings.carouselheight == 'clickexpand'){
	            		afterUpdate = function () {
			                self.cffUpdateSize(carouselElement);
			            };
			            afterInit = function(){
			                self.cffUpdateSize(carouselElement);
			            };
	            	}
						carouselElement.find('.cff-carousel-expand').remove();


	            var carouselSettings = {
	            	items: carouselCols,
		            itemsDesktop: [1199, carouselCols],
		            itemsDesktopSmall: false,
		            itemsTablet: false,
		            itemsTabletSmall: false,
		            itemsMobile: [479, carouselMobileCols],
		            navigation: carouselArrows,
		            navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
		            dots: carouselPag,
		            autoplay:carouselautoplay,
					autoplayTimeout:carouselTime,
		            stopOnHover: true,
		            singleItem : singleItem,
    				autoHeight : autoHeight,
		            margin: 20,

		           afterUpdate: afterUpdate,
		           afterInit: afterInit
	            };
				carouselElement.owlCarousel(carouselSettings);
				carouselElement.on('changed.owl.carousel',function(){
					self.generateNavigationCarousel(customizerSettings, carouselElement);
				})
				self.generateCarouselHTMLAttributes(carouselElement);

			    if(customizerSettings.carouselheight == 'clickexpand'){
					var elementHeights = carouselElement.find('.owl-item').map(function() {
			            return jQuery(this).height();
			        }).get();
					var maxHeight = Math.max.apply(null, elementHeights),
						$owlWrapperOuter = carouselElement.find('.owl-stage-outer'),
			            moreClass = 'cff_carousel-more',
	        		    lessClass = 'cff-carousel-less',
	            		moreText = '<i class="fa fa-plus"></i>',
		            	lessText = '<i class="fa fa-minus"></i>',
	     		        moreHtml = '<a href="#" class="cff-carousel-expand '+moreClass+'"><span>'+moreText+'</span></a>';
	     		    if(carouselElement.find('.cff-carousel-expand').length == 0){
	            		$owlWrapperOuter.after(moreHtml);
	     		    }
	            	carouselElement.find('.cff_carousel-more').on('click', function(e) {
		                e.preventDefault();
		                var $thisMoreButton = jQuery(this);
		                if( jQuery(this).hasClass(lessClass) ) {
		                	var minHeight = parseInt(carouselElement.find('.owl-item').eq(0).outerHeight);
				            carouselElement.find('.owl-item').each(function() {
				                var thisHeight = parseInt(jQuery(this).css('height'));
				                minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
				            });
		                    $owlWrapperOuter.animate({
		                        height: minHeight+'px'
		                    }, 400);
		                    $thisMoreButton.removeClass(lessClass).find('span').html(moreText);
		                } else {
		                    self.cffFeedHeightToggle(maxHeight, carouselElement);
		                    $thisMoreButton.addClass(lessClass).find('span').html(lessText);
		                }
		            });
				}
			    self.cffUpdateSize(carouselElement);



			}
		},

		/**
		 * Carousel Expand Size
		 *
		 * @since 4.0
		*/
		cffUpdateSize : function(carouselElement){
			var self 		  = this,
				customizerSettings = self.customizerFeedData.settings;
			if(customizerSettings.carouselheight == 'clickexpand'){
				setTimeout(function(){ //Slight delay so images can fully load before calculating min height
		            var minHeight = parseInt(carouselElement.find('.owl-item').eq(0).outerHeight);
		            carouselElement.find('.owl-item').each(function() {
		                var thisHeight = parseInt(jQuery(this).css('height'));
		                minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
		            });
		            carouselElement.find('.owl-stage-outer').css('height',minHeight+'px');
		        }, 200);
			}
		},

		/**
		 * Carousel Expand Toggle Feed Height
		 *
		 * @since 4.0
		*/
		cffFeedHeightToggle : function(maxHeight, $self){
			 var commentsOpenHeights = new Array(),
	            $owlWrapperOuter = $self.find('.owl-stage-outer'),
	            $commentBox = $self.find('.cff-comments-box');

	        $commentBox.each(function() {
	            var $thisCommentBox = jQuery(this);
	            if($thisCommentBox.is(':visible')) {
	                var thisPostHeight = parseInt($thisCommentBox.closest('.owl-item').eq(0).css('height'));
	                commentsOpenHeights.push(thisPostHeight);
	            }
	        }).promise().done(function () { // wait for the heights of all of the open comments to be recorded before resetting the feed height
	            if(commentsOpenHeights.length) {
	                setTimeout(function () {
	                    var greatestPostHeight = Math.max.apply(null, commentsOpenHeights);
	                    $owlWrapperOuter.animate({
	                        height: greatestPostHeight + 'px'
	                    }, 400);
	                }, 500);
	            } else {
	                $owlWrapperOuter.animate({
	                    height: maxHeight + 'px'
	                }, 400);
	            }
	        });
		},

		/**
		 * Generate Carousel HTML Attributes
		 *
		 * @since 4.0
		*/
		generateCarouselHTMLAttributes : function(carouselElement){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;
			carouselElement.attr({
				'data-navigation' : customizerSettings.carouselnavigation
			});
			self.generateNavigationCarousel(customizerSettings, carouselElement);
		},

		/**
		 * Generate Carousel Navigation
		 *
		 * @since 4.0
		*/
		generateNavigationCarousel : function(customizerSettings, carouselElement){
			var self = this;
			if(customizerSettings.carouselnavigation == 'below'){
				var $navigation = carouselElement.find('.owl-dots');
				carouselElement.find('.owl-nav').remove();
				if($navigation.children('.owl-prev').length <= 0){
					$navigation.prepend('<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>');
				}
				if($navigation.children('.owl-next').length <= 0){
					$navigation.append('<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>');
				}
			}
		},

		/**
		 * Disable JQuery Plugin Nodes
		 *
		 * @since 4.0
		*/
		disableJQueryNodes : function(){
			var self 		  = this,
				customizerSettings = self.customizerFeedData.settings,
				carouselElement = jQuery('.cff-preview-posts-list-ctn');
			if(self.activeExtensions['carousel'] == true){
				carouselElement.owlCarousel('destroy');
				carouselElement.removeClass('cff-carousel');
				carouselElement.removeAttr('data-navigation');
			}
		},

		/**
		 * Reinit Carousel Element
		 *
		 * @since 4.0
		*/
		reinitCarouselHTML : function(){
			var self 		  = this,
				customizerSettings = self.customizerFeedData.settings,
				carouselElement = jQuery('.cff-preview-posts-list-ctn');
			if(self.activeExtensions['carousel'] == true){
				carouselElement.owlCarousel('destroy');
				carouselElement.removeClass('cff-carousel');
				carouselElement.removeAttr('data-navigation');
				if(customizerSettings.feedlayout === 'carousel'){
					self.loadingBar = true;
					setTimeout(function(){
						self.generateCarouselSettings();
						self.processNotification('carouselLayoutUpdated');
					}, 150)
				}
			}

		},

		/**
		 * Generate the Feed Posts Height For Masonry & Grid Layouts
		 *
		 * @since 4.0
		 */
		generateMasonryGridHeight : function(typeAppend){
			var self 		  = this,
				feedlayout 	  = self.customizerFeedData.settings.feedlayout,
				feedtype 	  =	self.customizerFeedData.settings.feedtype,
				currentDevice = self.customizerScreens.previewScreen;
			jQuery('.cff-carousel-expand').remove();

			//Masonry Layout
			if(feedlayout === 'masonry'){
				setTimeout(function() {
					var $masonryParent = jQuery('.cff-preview-posts-masonry').isotope({
					  	itemSelector: '.cff-post-item-ctn',
					  	percentPosition: true,
					  	masonry: {
					    	columnWidth: '.cff-post-item-ctn'
					  	}
					});
					// layout Isotope after each image loads
					$masonryParent.imagesLoaded().progress( function() {
					  	if(typeAppend == 'update'){
					  		$masonryParent.isotope('reloadItems').isotope();
					  	}else{
					  		$masonryParent.isotope('layout');
					  	}
					});
				}, 500)
			}else{
				if(jQuery('.cff-preview-posts-list-ctn').data('isotope')){
					jQuery('.cff-preview-posts-list-ctn').isotope('destroy')
				}
			}

			//Grid Layout
			if(feedlayout === 'grid'){
				setTimeout(function() {
					var grid = document.getElementsByClassName('cff-preview-posts-grid')[0];
					if( grid ) {
				       var allItems = document.querySelectorAll('.cff-post-item-ctn');
				       if( allItems ) {
				       		var plusHeight = (feedtype == 'videos' || feedtype == 'albums') ? 70 : 0;
				        	allItems.forEach( function(item, index) {
				        		item.style.height = parseFloat(item.getBoundingClientRect().width + plusHeight) + 'px';
					 		    item.style.gridRowEnd = 'unset';
				        	});
				       }
					}
				}, 500)
			}

			if(feedlayout == 'carousel'){
				setTimeout(function() {
					var allItems = document.querySelectorAll('.cff-post-item-ctn');
					if( allItems ) {
						allItems.forEach( function(item, index) {
							item.style.height = 'unset';
							item.style.gridRowEnd = 'unset';
						});
					}
				}, 500)
			}

			if(feedlayout == 'carousel' && feedtype == 'singlealbum'){
				setTimeout(function() {
					var allItems = document.querySelectorAll('.owl-item');
					if( allItems ) {
						allItems.forEach( function(item, index) {
							item.style.height = item.getBoundingClientRect().width + 'px';
							item.style.gridRowEnd = 'unset';
						});
					}
				}, 500)
			}

		},


		/**
		 * Get Feed Columns Depending on the Settings
		 *
		 * @since 4.0
		 *
		 * @return String | Bool
		 */
		getFeedColumns : function(){
			var self 		  = this,
				feedlayout 	  = self.customizerFeedData.settings.feedlayout,
				feedtype 	  =	self.customizerFeedData.settings.feedtype,
				currentDevice = self.customizerScreens.previewScreen;

 			if(feedlayout === 'masonry' || (feedlayout === 'grid' && feedtype !== 'timeline')){
 				switch (currentDevice) {
 					case 'desktop':
 						return self.customizerFeedData.settings.cols;
					case 'tablet':
 						return self.customizerFeedData.settings.colstablet;
					case 'mobile':
 						return self.customizerFeedData.settings.colsmobile;
 				}
 			}
 			return false;
		},

		/**
		 * Toggle Comment Section
		 *
		 * @since 4.0
		 */
		toggleCommentSection : function(postID){
			var self = this;
			if(self.showedCommentSection.includes(postID)){
				self.showedCommentSection.splice(self.showedCommentSection.indexOf(postID), 1);
			}else{
				self.showedCommentSection.push(postID);
			}
			setTimeout(function(){
				self.generateMasonryGridHeight('update');
			}, 100)
			cffBuilder.$forceUpdate();
		},

		/**
		 * Ajax Action : Save Feed Settings
		 *
		 * @since 4.0
		 */
		saveFeedSettings : function(){
			var self = this,
				sources = [],
				updateFeedData = {
					action : 'cff_feed_saver_manager_builder_update',
					update_feed	: 'true',
					feed_id : self.customizerFeedData.feed_info.id,
					feed_name : self.customizerFeedData.feed_info.feed_name,
					settings : self.customizerFeedData.settings,
					sources : []
				};

			if(self.customizerFeedData.settings.sources.length > 0){
				self.customizerFeedData.settings.sources.forEach(function(source){
					updateFeedData.sources.push(source.account_id);
				})
			}
			self.loadingBar = true;
			self.ajaxPost(updateFeedData, function(_ref){
				var data = _ref.data;
				if(data && data.success === true){
					self.processNotification('feedSaved');
					self.customizerFeedDataInitial = self.customizerFeedData;
				}else{
					self.processNotification('feedSavedError');
				}
			});
			cffBuilder.$forceUpdate();
		},

		/**
		 * Ajax Action : Clear Single Feed Cache
		 * Update Feed Preview Too
		 * @since 4.0
		 */
		clearSingleFeedCache  : function(){
			var self = this,
				sources = [],
				clearFeedData = {
					action : 'cff_feed_saver_manager_clear_single_feed_cache',
					feedID : self.customizerFeedData.feed_info.id,
					previewSettings : self.customizerFeedData.settings,
				};
			self.loadingBar = true;
			self.ajaxPost(clearFeedData, function(_ref){
				var data = _ref.data;
				if( data !== false ){
					self.customizerFeedData.posts = data.posts;
					self.customizerFeedData.header = data.header;
					self.processNotification('cacheCleared');
				}else{
					self.processNotification("unkownError");
				}
			})
			cffBuilder.$forceUpdate();
		},

		/**
		 * Clear & Reset Color Override
		 *
		 * @since 4.0
		*/
		resetColorOverride : function(settingID){
			this.customizerFeedData.settings[settingID] = '';
		},

		/**
		 * Print Story
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		printStory : function(singlePost){
			var self = this,
				authorName = self.hasOwnNestedProperty(singlePost, 'from.name') ? singlePost.from.name  : null,
				postStory = self.hasOwnNestedProperty(singlePost, 'story') && authorName != null ? singlePost.story.replace(authorName, '') : null;
			return postStory;
		},


		/**
		 * Format & Print Date
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		printDate : function( postDate, eventDate = false ){
			var self = this,
				originalDate 	= Date.parse(postDate) / 1000,
				dateOffset 		= new Date(),
				offsetTimezone 	= dateOffset.getTimezoneOffset(),
				periods = [
					self.translatedText.secondText,
					self.translatedText.minuteText,
					self.translatedText.hourText,
					self.translatedText.dayText,
					self.translatedText.weekText,
					self.translatedText.monthText,
					self.translatedText.yearText
				],
				periodsPlural = [
					self.translatedText.secondsText,
					self.translatedText.minutesText,
					self.translatedText.hoursText,
					self.translatedText.daysText,
					self.translatedText.weeksText,
					self.translatedText.monthsText,
					self.translatedText.yearsText
				],
				lengths		 = ["60","60","24","7","4.35","12","10"],
				now 		= dateOffset.getTime()  / 1000,
				newTime 	= originalDate + offsetTimezone,
				printDate 	= '',
				dateFortmat = eventDate ? self.customizerFeedData.settings.eventdateformat : self.customizerFeedData.settings.dateformat,
				agoText 		= self.translatedText.agoText,
				difference 	= null,
				formatsChoices = {
					'2' : 'F jS, g:i a',
					'3' : 'F jS',
					'4' : 'D F jS',
					'5' : 'l F jS',
					'6' : 'D M jS, Y',
					'7' : 'l F jS, Y',
					'8' : 'l F jS, Y - g:i a',
					'9' : "l M jS, 'y",
					'10' : 'm.d.y',
					'11' : 'm/d/y',
					'12' : 'd.m.y',
					'13' : 'd/m/y',
					'14' : 'd-m-Y, G:i',
					'15' : 'jS F Y, G:i',
					'16' : 'd M Y, G:i',
					'17' : 'l jS F Y, G:i',
					'18' : 'm.d.y - G:i',
					'19' : 'd.m.y - G:i'
				};

			if ( eventDate ) {
				formatsChoices = {
					'14' : 'M j, g:ia',
					'15' : 'M j, G:i',
					'1' : 'F j, Y, g:ia',
					'2' : 'F jS, g:ia',
					'3' : 'g:ia - F jS',
					'4' : 'g:ia, F jS',
					'5' : 'l F jS - g:ia',
					'6' : 'D M jS, Y, g:iA',
					'7' : 'l F jS, Y, g:iA',
					'8' : 'l F jS, Y - g:ia',
					'9' : "l M jS, 'y",
					'10' : 'm.d.y - g:iA',
					'20' : 'm.d.y - G:i',
					'11' : 'm/d/y, g:ia',
					'12' : 'd.m.y - g:iA',
					'21' : 'd.m.y - G:i',
					'13' : 'd/m/y, g:ia',
					'16' : 'd-m-Y, G:i',
					'17' : 'jS F Y, G:i',
					'18' : 'd M Y, G:i',
					'19' : 'l jS F Y, G:i',
				};
			}

				if(formatsChoices.hasOwnProperty(dateFortmat)){
					printDate = date_i18n( formatsChoices[dateFortmat], newTime );
				}else if(dateFortmat == 'custom'){
					var dateCustom = eventDate ? self.customizerFeedData.settings.eventdatecustom : self.customizerFeedData.settings.datecustom;
					if( eventDate ){
						dateCustom = dateCustom.replace("{hide-start}","<k>");
						dateCustom = dateCustom.replace("{hide-end}","</k>");
					}
					printDate = date_i18n( dateCustom , newTime );
				}
				else{
					if( now > originalDate ) {
	                	difference = now - originalDate;

					}else{
	                	difference = originalDate - now;
					}
					for(var j = 0; difference >= lengths[j] && j < lengths.length-1; j++) {
	              	 	difference /= lengths[j];
	            	}
	            	difference = Math.round(difference);
	            	if(difference != 1) {
		                periods[j] = periodsPlural[j];
		            }
					printDate = difference + " " + periods[j] + " "+ agoText;
				}

			return printDate;
		},

		/**
		 * Format & Print Event Date
		 *
		 * @since 4.0.10
		 *
		 * @return String
		 */
		printEventEndDate : function( startTime, endTime ){
			var self = this,
				startTime = self.printDate(startTime, true).match(/<k>(.*?)<\/k>/g),
				endTime = self.printDate(endTime, true),
				endTimeK = endTime.match(/<k>(.*?)<\/k>/g);
				if(startTime !== null &&  endTimeK !== null && startTime[0] == endTimeK[0]){
					return endTime.replace(endTimeK, '');
				}
			return endTime;
		},


		/**
		 * Print Event Location
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		getEventMapLink : function( place ){
			var self = this;
			latitude = (self.hasOwnNestedProperty(place,'location.latitude')) ? self.htmlEntities(place.location.latitude) : '',
			longitude = (self.hasOwnNestedProperty(place,'location.longitude')) ? self.htmlEntities(place.location.longitude) : '',
			locationMap = self.hasOwnNestedProperty(place,'name') ? self.htmlEntities(place.name) : '',
			mapUrl = false;
			if( self.hasOwnNestedProperty(place, 'location') ){
				mapUrl = 'https://maps.google.com/maps?q=' + latitude + ',+' + longitude;
			}else if( locationMap.match(/~[0-9]~/) && locationMap.length  > 10 ){
				mapUrl = 'https://maps.google.com/maps?q='+ location;
			}
			return mapUrl;
		},

		/**
		 * Posts List
		 *
		 * @since 4.0
		 *
		 * @return Array
		 */
		returnPostList : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings
			if(customizerSettings.feedtype == 'reviews'){
				return self.reviewsFeedTypeCheck();
			}else{
				var numberOfPosts = (self.customizerScreens.previewScreen == 'desktop') ? customizerSettings.num : (self.checkNotEmpty(customizerSettings.nummobile) ? customizerSettings.nummobile : customizerSettings.num);
					numberOfPosts = self.checkNotEmpty(numberOfPosts) ? numberOfPosts : 0;
                let returnedPosts = self.customizerFeedData.posts.filter( post => {
                    if(self.checkShowPost(post)){
                        return post;
                    }
                }  );
				return (customizerSettings.feedlayout == 'carousel') ? returnedPosts : returnedPosts.slice(0, numberOfPosts);
			}
		},

		/**
		 * Create String of Views Rated
		 *
		 * @since 4.0
		 *
		 * @return Array
		*/
		processReviewsRated : function(){
		 	var self = this,
		 		settings = self.customizerFeedData.settings,
		 		reviewsratedArray = [],
		 		star5 = self.valueIsEnabled(settings.cff_reviews_rated_5) ? reviewsratedArray.push(5) : reviewsratedArray.splice(reviewsratedArray.indexOf(5)),
		 		star4 = self.valueIsEnabled(settings.cff_reviews_rated_4) ? reviewsratedArray.push(4) : reviewsratedArray.splice(reviewsratedArray.indexOf(4)),
		 		star3 = self.valueIsEnabled(settings.cff_reviews_rated_3) ? reviewsratedArray.push(3) : reviewsratedArray.splice(reviewsratedArray.indexOf(3)),
		 		star2 = self.valueIsEnabled(settings.cff_reviews_rated_2) ? reviewsratedArray.push(2) : reviewsratedArray.splice(reviewsratedArray.indexOf(2)),
		 		star1 = self.valueIsEnabled(settings.cff_reviews_rated_1) ? reviewsratedArray.push(1) : reviewsratedArray.splice(reviewsratedArray.indexOf(1));
		 		self.customizerFeedData.settings.reviewsrated = reviewsratedArray.join(',');
		 		return reviewsratedArray;
		},


		/**
		 * Check & Process Reviews Feed Type
		 *
		 * @since 4.0
		 *
		 * @return Array
		 */
		 reviewsFeedTypeCheck : function(){
		 	var self = this,
			 	reviewArray = [],
		 		reviewsratedArray = self.processReviewsRated();

		 	self.customizerFeedData.posts.forEach( function(review, index) {
		 		if(
		 			(
		 				self.valueIsEnabled(self.customizerFeedData.settings.reviewshidenotext) && self.checkNotEmpty(review.review_text) == true
		 				)
		 			|| !self.valueIsEnabled(self.customizerFeedData.settings.reviewshidenotext)
		 			){
		 				var hasReviewRating  = review.rating != undefined && review.rating != null;
		 				if( ( hasReviewRating && reviewsratedArray.includes(review.rating) ) || !hasReviewRating ){
				 			reviewArray.push({
				 				created_time : review.created_time,
				 				recommendation_type : review.recommendation_type,
				 				message : review.review_text,
				 				from : review.reviewer,
				 				rating : review.rating ? review.rating : undefined
				 			});
		 				}
			 		}
		 	});
	 		return reviewArray;
		 },


		/**
		 * HTML Entities
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		htmlEntities : function (str) {
		    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		},

		/**
		 * Check Process Post Image
		 *
		 * @since 4.0
		 */
		checkProcessPostImage : function( post ){
			var self = this,
			showImage = self.customizerFeedData.settings.include.includes('media') && (post.status_type == 'added_photos' || post.status_type == 'created_event' || self.customizerFeedData.settings.feedtype == 'events');
			imageExist = self.hasOwnNestedProperty(post, 'full_picture') ? true : (  self.hasOwnNestedProperty(post , 'attachments.data') &&  post.attachments.data[0] &&  post.attachments.data[0].media ? true : false);
			if( self.customizerFeedData.settings.feedtype == 'events' ){
				imageExist = self.hasOwnNestedProperty(post, 'cover.source');
			}
			return imageExist && showImage;
		},

		/**
		 * Process Post Image Source
		 *
		 * @since 4.0
		 */
		processPostImageSrc : function( post ){
			var self = this;
			if(self.customizerFeedData.settings.feedtype == 'events' && self.hasOwnNestedProperty(post, 'cover.source') ){
				return post.cover.source;
			}
			return self.hasOwnNestedProperty(post, 'full_picture') ? post.full_picture : post.attachments.data[0].media.image.src
		},

		/**
		 * Process Video LightBox
		 *
		 * @since 4.0
		 */
		processPostVideoSrc : function( singlePost ){
			var self = this,
				videoInfo = self.processIframeAndLinkAndVideo( singlePost ),
				videoSource = null;
			if( self.hasOwnNestedProperty( videoInfo, 'type' ) ){
				switch (videoInfo.type) {
					case 'embed':
						videoSource = self.hasOwnNestedProperty(videoInfo, 'url') ? videoInfo.url : null;
					break;
					case 'video':
						videoSource = self.hasOwnNestedProperty(videoInfo, 'args.unshimmedUrl') ?  'https://www.facebook.com/v2.3/plugins/video.php?href=' + videoInfo.args.unshimmedUrl : null;
					break;
				}
			}
			return videoSource;
		},



		/**
		 * Print Album Attachment Number
		 *
		 * @since 4.0
		 */
		printAlbumImageNumberOverlay : function(subAttachmentsArray){
			return '+' + (subAttachmentsArray.length - 3).toString();
		},

		/**
		 * Print Element Overlay
		 *
		 * @since 4.0
		 */
		getPostElementOverlay : function( singlePost ){
			var self 		= this,
				postType 	= self.getPostTypeTimeline(singlePost),
				activeImage = null,
				videoSource = null,
				domBody = document.getElementsByTagName("body")[0];
				/*
				videos
				links
				photos
				albums
				events
				*/
			switch (postType) {
				case 'photos':
					activeImage = self.processPostImageSrc(singlePost);
				break;
				case 'albums':
					activeImage = self.processPostImageSrc(singlePost);
				break;
				case 'events':
					activeImage = self.processPostImageSrc(singlePost);
				break;
				case 'videos' :
					postType = 'videos';
					videoSource = self.processPostVideoSrc(singlePost);
				break;
			}
			if(self.customizerFeedData.settings.feedtype == 'videos'){
				postType = 'embed_videos';
				videoSource = singlePost.embed_html;
			}

			self.lightBox = {
				visibility 	: 'shown',
				type 		: postType,
				post 		: singlePost,
				activeImage : activeImage,
				albumIndex 	: 0,
				videoSource : videoSource
			};

			document.body.scrollTop = 0;
			document.documentElement.scrollTop = 0;
			domBody.classList.add("no-overflow");
			cffBuilder.$forceUpdate();

		},


		/**
		 * Print Element Overlay
		 *
		 * @since 4.0
		 */
		hideLightBox : function(){
			var self 		= this,
			domBody = document.getElementsByTagName("body")[0];
			domBody.classList.remove("no-overflow");
			self.lightBox = {
				visibility 	: 'hidden',
				type 		: null,
				post 		: null,
				activeImage : null,
				albumIndex 	: 0,
				videoSource : null
			};
			self.dummyLightBoxData.visibility = 'hidden';
			cffBuilder.$forceUpdate();
		},

		/**
		 * Switch Album Image onLick
		 *
		 * @since 4.0
		 */
		switchLightboxAlbumImage : function(imageSource, imageIndex){
			var self 		= this;
			self.lightBox.activeImage = imageSource;
			self.lightBox.albumIndex = imageIndex;
			cffBuilder.$forceUpdate();
		},

		/**
		 * Navigate Album Image
		 * Next / Previous
		 * @since 4.0
		 */
		navigateLightboxAlbumImage : function(navType, images){
			var self 		= this,
			activeIndex 	= (navType == 'prev') ? ( self.lightBox.albumIndex === 0 ? images.length - 1 : self.lightBox.albumIndex - 1 ) : (self.lightBox.albumIndex === images.length - 1 ? 0 : self.lightBox.albumIndex + 1  );
			self.lightBox.albumIndex = activeIndex;
			self.lightBox.activeImage = images[activeIndex].media.image.src;
			cffBuilder.$forceUpdate();
		},

		/**
		 * Print Post Text
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		printPostText : function( post, fullText = false ){
			var self = this,
			postText = post.message ? post.message : (post.description ? post.description : '');

			if( self.getPostTypeTimeline(post) === 'photos'){
				postText = self.hasOwnNestedProperty(post, 'attachments.data') &&  post.attachments.data[0] != undefined ? post.attachments.data[0].description : postText;
			}

			postText = ( !self.checkNotEmpty(postText) && self.getPostTypeTimeline(post) == 'links' && self.hasOwnNestedProperty( self.processIframeAndLinkAndVideo( post ), 'args.title' ) ) ?
					self.processIframeAndLinkAndVideo( post ).args.title : postText,

			//postVideoEmbed = self.processIframeAndLink( post, postText ),
			postText = (!fullText && postText != null) ? postText.substring(0, self.customizerFeedData.settings.textlength) : postText,
			postTags = post.message_tags ? post.message_tags : null,
			postText = ( !self.valueIsEnabled(self.customizerFeedData.settings.textlink) ) ? self.processPostTags( self.processPostUrls( self.processNewLine( postText ) ), postTags ) : '<a href="https://www.facebook.com/'+post.id+'" target="_blank">' + postText + '</a>';
			return postText;
		},

		/**
		 * Return Tags Links for Post
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		processPostTags : function( postText, postTags ){
			if(postTags !== null){
				postTags.forEach( function( singleTag ) {
					var regEx = new RegExp(singleTag.name, "ig");
					//var singleTagName = postText.slice(singleTag.offset, (singleTag.offset + singleTag.length));
					postText = postText.replace(singleTag.name, '<a href="https://facebook.com/' + singleTag.id + '" target="_blank" rel="nofollow">' + singleTag.name + '</a>');
				});
			}
			return postText;
		},

		/**
		 * Return Tags Links for Post
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		processPostUrls: function( postText ){
			if(postText != null){
			 	var replacedText,
			 		httpPattern,
			 		wwwPattern,
			 		mailtoPattern;
			    httpPattern = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
			    replacedText = postText.replace(httpPattern, '<a href="$1" target="_blank">$1</a>');

			    wwwPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
			    replacedText = replacedText.replace(wwwPattern, '$1<a href="http://$2" target="_blank">$2</a>');

			    mailtoPattern = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
			    replacedText = replacedText.replace(mailtoPattern, '<a href="mailto:$1">$1</a>');

			    return replacedText
			}
			return postText;
		},

		/**
		 * Process New Line Break
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		processNewLine : function( postText ){
			return postText != null ? postText.replace(/(?:\r\n|\r|\n)/g, '<br />') : postText;
		},

		/**
		 * Create iFrame & External Link & Video
		 *
		 * @since 4.0
		 *
		 * @return array
		 */
		processIframeAndLinkAndVideo : function( post ){
			var self = this,
				postText = post.message ? post.message : (post.description ? post.description : ''),
				videoOrLink = self.processVideoAndLink( post );

			if( videoOrLink != false && self.hasOwnNestedProperty(videoOrLink, 'args.unshimmedUrl') && videoOrLink.args.unshimmedUrl != null){
				//Youtube Process
				var regExpYoutube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/,
			    	matchYoutube = videoOrLink.args.unshimmedUrl.match(regExpYoutube),
				    youtubeID =  (matchYoutube && matchYoutube[2].split(' ')[0].length === 11) ? matchYoutube[2].split(' ')[0] : null;

				//Vimeo Process
				var regExpVimeo = /vimeo.*\/(\d+)/i ,
			    	matchVimeo = regExpVimeo.exec( videoOrLink.args.unshimmedUrl ),
				    vimeoID =  (matchVimeo && matchVimeo[1]) ? matchVimeo[1] : null;

				//Soundcloud Process
				const regExpSoundCloud = /^.*(?:(https?):\/\/)?(?:(?:www|m)\.)?(soundcloud\.com|snd\.sc)\/(.*).*/,
					matchSoundCloud = videoOrLink.args.unshimmedUrl.match(regExpSoundCloud),
				    soundCloudUrl =  (matchSoundCloud && matchSoundCloud[2]) ? matchSoundCloud[3].split(' ')[0] : null;

				//Spotify Process
				var regExpSpotify =  /^.*((open|play)\.spotify\.com\/)([^#&?]*).*/,
					matchSpotify = videoOrLink.args.unshimmedUrl.match(regExpSpotify);
					spotifyUrl =  (matchSpotify && matchSpotify[2]) ? matchSpotify[3].split(' ')[0] : null;

				if(youtubeID  != null){
					return {
						'type' : 'embed',
						'url'  : 'https://www.youtube.com/embed/' + youtubeID,
						'site' : 'video'
					};
				}else if( vimeoID  != null ){
					return {
						'type' : 'embed',
						'url'  : '//player.vimeo.com/video/'+vimeoID,
						'site' : 'video'
					};
				}else if(soundCloudUrl != null){
					return {
						'type' : 'embed',
						'url'  : 'https://w.soundcloud.com/player/?url=https://soundcloud.com/'+soundCloudUrl+'&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false&amp;visual=false',
						'site' : 'soundcloud'
					};
				}else if( spotifyUrl != null){
					return {
						'type' : 'embed',
						'url'  : 'https://open.spotify.com/embed/'+spotifyUrl,
						'site' : 'spotify'
					};
				}
			}

			return videoOrLink;
		},


		/**
		 * Process Video & External Link
		 *
		 * @since 4.0
		 *
		 * @return array
		 */
		processVideoAndLink : function( post ){
			var self = this;
			if( self.hasOwnNestedProperty(post, 'attachments.data') &&  post.attachments.data[0] ){
				if( post.attachments.data[0] && ( post.attachments.data[0].media_type === 'link' || post.attachments.data[0].media_type === 'video' ) ){
					var dataObject = post.attachments.data[0];
					switch (dataObject.media_type) {
						case 'video':
							return {
								'type' : 'video',
								'args' : {
									'title' 		: self.hasOwnNestedProperty( dataObject, 'title' ) 			? dataObject.title : null,
									'source' 		: self.hasOwnNestedProperty( dataObject, 'media.source') 	? dataObject.media.source : null,
									'poster' 		: self.hasOwnNestedProperty( dataObject, 'media.image.src') ? dataObject.media.image.src : null,
									'unshimmedUrl' 	: self.hasOwnNestedProperty( dataObject, 'unshimmed_url') 	? dataObject.unshimmed_url : null
								}
							};
						case 'link':
							var domain = (self.hasOwnNestedProperty( dataObject, 'unshimmed_url')) ? (new URL(dataObject.unshimmed_url)).hostname : null;
							return {
								'type' : 'link',
								'args' : {
									'title' 		: self.hasOwnNestedProperty( dataObject, 'title' ) 			? dataObject.title : null,
									'description' 	: self.hasOwnNestedProperty( dataObject, 'description') 	? dataObject.description : null,
									'poster' 		: self.hasOwnNestedProperty( post, 'full_picture') 			? post.full_picture : null,
									'unshimmedUrl' 	: self.hasOwnNestedProperty( dataObject, 'unshimmed_url') 	? dataObject.unshimmed_url : null,
									'domain' 		: domain
								}
							};
					}
				}
			}else if(post.embed_html){
				return {
					'type' : 'video',
					'args' : {
						'title' 		: self.hasOwnNestedProperty( post, 'title' ) 				? post.title : null,
						'source' 		: self.hasOwnNestedProperty( post, 'source') 				? post.source : null,
						'poster' 		: self.hasOwnNestedProperty( post, 'format') 				? post.format[post.format.length - 1].picture : null,
						'unshimmedUrl' 	: self.hasOwnNestedProperty( post, 'from.id') && self.hasOwnNestedProperty( post, 'id') ? 'https://www.facebook.com/'+post.from.id+'/videos/'+ post.id +'/' : null
					}
				};
			}

			return false;
		},

		/**
		 * Get Post Type
		 *
		 * @since 4.0
		 *
		 * @return string
		 */
		getPostTypeTimeline : function( post ){
			var self = this,
				postType = (post.message) ? 'statuses' : (post.description ? 'statuses' : 'empty');

			if( self.hasOwnNestedProperty(post, 'attachments.data') &&  post.attachments.data[0] ){
				if( post.attachments.data[0].media_type ){
					switch (post.attachments.data[0].media_type) {
						case 'video':
							postType = 'videos';
							break;
						case 'link':
							postType = 'links';
							break;
						case 'photo':
							postType = 'photos';
							break;
						case 'album':
							postType = 'albums';
							break;
						case 'event':
							postType = 'events';
							break;
					}
				}
			}
			return postType;
		},

		/**
		 * Show or Hide Post Depending on settings
		 *
		 * @since 4.0
		 *
		 * @return bool
		 */
		checkShowPost : function( post ){
			var self = this,
				feedType = self.customizerFeedData.settings.feedtype,
				type = self.customizerFeedData.settings.type,
				postType = self.getPostTypeTimeline( post ),
				showPost = true;
			//'links,events,videos,photos,albums,statuses',
			if(feedType == 'timeline'){
				showPost = type.includes( postType );
			}
			return showPost;
		},


		/**
		 * Process Photos Feedtype =>  Single Image Source
		 *
		 * @since 4.0
		 *
		 * @return string
		 */
		processPhotoSource : function( post ){
			var pictureSourceFallBack = 'https://graph.facebook.com/'+ post.id +'/picture?type=normal&width=9999&height=9999&access_token=' + ((this.customizerFeedData.settings.sources[0] != undefined) ? this.customizerFeedData.settings.sources[0].access_token : ''),
				pictureSrc = ( post.images &&  post.images[0] && post.images[0].source) ? post.images[0].source : (post.full_picture || pictureSourceFallBack);
			if(post.images){
				var currentWidth = 0;
				post.images.forEach( function(singleImage) {
					if( singleImage.width > 500 && singleImage.width < 900 && currentWidth < singleImage.width){
						pictureSrc = singleImage.source;
						currentWidth = singleImage.width;
					}
				});
			}
			return pictureSrc;
		},


		/**
		 * Process Video Source Image
		 * Videos Feed Type
		 * @since 4.0
		 *
		 * @return string
		 */
		processVideosFeedImage : function( videoPost ){
			var self = this,
				pictureSrc = '';
			if( self.hasOwnNestedProperty(videoPost, 'format') && Array.isArray(videoPost.format) ){
				pictureSrc = videoPost.format[videoPost.format.length - 1].picture;
			}
			return pictureSrc;
		},


		/**
		 * Print Expand Text
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		printExpandText : function( postID ){
			var self = this;
			return self.expandedPostText.includes(postID) ? self.translatedText.seeLessText : self.translatedText.seeMoreText;
		},

		/**
		 * Print Expand Text
		 *
		 * @since 4.0
		 */
		expandPostText : function( postID ){
			var self = this;
			if(self.expandedPostText.includes(postID)){
				self.expandedPostText.splice(self.expandedPostText.indexOf(postID), 1);
			}else{
				self.expandedPostText.push(postID);
			}
			setTimeout(function(){
				self.generateMasonryGridHeight('update');
			}, 100)
			cffBuilder.$forceUpdate();

		},

		/**
		 * Return Likebox Iframe
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		displayLikeBoxIframe : function(){
			var self = this,
				pageID = self.hasOwnNestedProperty(self.customizerFeedData, 'header.id') ? self.customizerFeedData.header.id : null,
				settings = self.customizerFeedData.settings,
				likeBoxWidth = self.valueIsEnabled(settings.likeboxcustomwidth) && self.checkNotEmpty(settings.likeboxcustomwidth) ? settings.likeboxwidth : 300,
				iframeURL = 'https://www.facebook.com/'+pageID+'/tabs&width=' + likeBoxWidth +
				'&small_header=' + self.valueIsEnabled(settings.likeboxsmallheader) +
				'&adapt_container_width=true' +
				'&hide_cover=' + !self.valueIsEnabled(settings.likeboxcover) +
				'&hide_cta=' + self.valueIsEnabled(settings.likeboxhidebtn) +
				'&show_facepile=' + self.valueIsEnabled(settings.likeboxfaces) +
				'&locale=' + settings.locale;
			return 'https://www.facebook.com/plugins/page.php?href='+iframeURL;
		},

		/**
		 * Single Post & Feature Post Holder Areas
		 *
		 * @since 4.0
		 */
		 singleHolderParams : function(){
			var self = this,
			postsLength = self.customizerFeedData.posts ? self.customizerFeedData.posts.length : 0;
			holderIcon = '',
			holderHeading = '',
			holderText = '',
			settings = self.customizerFeedData.settings;
			if( settings.feedtype == 'singlealbum' ){
				holderIcon 		= self.checkNotEmpty(settings.album) && postsLength == 0 ? self.svgIcons['issueSinglePreview'] :  self.svgIcons['albumsPreview'];
				holderHeading 	= self.checkNotEmpty(settings.album) && postsLength == 0 ? self.addFeaturedAlbumScreen.couldNotFetch : self.addFeaturedAlbumScreen.previewHeading;
				holderText 		= self.checkNotEmpty(settings.album) && postsLength == 0 ? self.addFeaturedAlbumScreen.unablePreview : self.addFeaturedAlbumScreen.previewText;
			}
			if( settings.feedtype == 'featuredpost' ){
				holderIcon 		= self.checkNotEmpty(settings.featuredpost) && postsLength == 0 ? self.svgIcons['issueSinglePreview'] :  self.svgIcons['featuredPostPreview'];
				holderHeading 	= self.checkNotEmpty(settings.featuredpost) && postsLength == 0 ? self.addFeaturedPostScreen.couldNotFetch : self.addFeaturedPostScreen.previewHeading;
				holderText 		= self.checkNotEmpty(settings.featuredpost) && postsLength == 0 ? self.addFeaturedPostScreen.unablePreview : self.addFeaturedPostScreen.previewText;
			}

			return  {
				icon : holderIcon,
				heading : holderHeading,
				text : holderText
			};

		},

		/**
		 * Toggle Social Share Tooltip
		 *
		 * @since 4.0
		 */
		toggleSocialShareTooltip : function( postID ){
			var self = this;
			self.showedSocialShareTooltip = (self.showedSocialShareTooltip === postID) ? null : postID;
			cffBuilder.$forceUpdate();
		},

		/**
		 * Remove Source Form List Multifeed
		 *
		 * @since 4.0
		 */
		removeSourceCustomizer : function(type, args = []){
			var self = this;
			Object.assign(self.customizerScreens.sourcesChoosed,self.customizerFeedData.settings.sources);
			self.selectSourceCustomizer(args, true);
			cffBuilder.$forceUpdate();
			window.event.stopPropagation();
		},


		/**
		 * Open Dialog Box
		 *
		 * @since 4.0
		 */
		openDialogBox : function(type, args = []){
			var self = this,
			heading = self.dialogBoxPopupScreen[type].heading,
			description = self.dialogBoxPopupScreen[type].description;
			switch (type) {
				case "deleteSourceCustomizer":
					self.sourceToDelete = args;
					heading = heading.replace("#", self.sourceToDelete.username);
				break;
				case "deleteSingleFeed":
					self.feedToDelete = args;
					heading = heading.replace("#", self.feedToDelete.feed_name);
				break;
			}
			self.dialogBox = {
				active : true,
				type : type,
				heading : heading,
				description : description
			};
			window.event.stopPropagation();
		},

		/**
		 * Confirm Dialog Box Actions
		 *
		 * @since 4.0
		 */
		confirmDialogAction : function(){
			var self = this;
			switch (self.dialogBox.type) {
				case 'deleteSourceCustomizer':
					self.selectSourceCustomizer(self.sourceToDelete, true);
					self.customizerControlAjaxAction('feedFlyPreview');
				break;
				case 'deleteSingleFeed':
					self.feedActionDelete([self.feedToDelete.id]);
				break;
				case 'deleteMultipleFeeds':
					self.feedActionDelete(self.feedsSelected);
				break;
				case 'backAllToFeed':
					window.location = self.builderUrl;
				break;
			}
		},

		/*
		closeConfirmDialog : function(){
			this.sourceToDelete = {};
			this.feedToDelete = {};
			this.dialogBox = {
				active : false,
				type : null,
				heading : null,
				description : null
			};
		},
		*/

		/**
		 * Show Tooltip on Hover
		 *
		 * @since 4.0
		 */
		toggleElementTooltip : function(tooltipText, type, align = 'center'){
			var self = this,
				target = window.event.currentTarget,
				tooltip = (target != undefined && target != null) ? document.querySelector('.sb-control-elem-tltp-content') : null;
			if(tooltip != null && type == 'show'){
				self.tooltip.text = tooltipText;
				var position = target.getBoundingClientRect(),
					left = position.left + 10,
					top = position.top - 10;
				tooltip.style.left = left + 'px';
				tooltip.style.top = top + 'px';
                tooltip.style.textAlign = align;
				self.tooltip.hover = true;
			}
			if(type == 'hide'){
				setTimeout(function(){
					if(self.tooltip.hoverType != 'inside'){
						self.tooltip.hover = false;
					}
				}, 200)
			}
		},

		/**
		 * Hover Tooltip
		 *
		 * @since 4.0
		 */
		hoverTooltip : function(type, hoverType){
			this.tooltip.hover = type;
			this.tooltip.hoverType = hoverType;
		},

		/**
		 * Loading Bar & Notification
		 *
		 * @since 4.0
		 */
		processNotification : function( notificationType ){
			var self = this,
				notification = self.genericText.notification[ notificationType ];
			self.loadingBar = false;
			self.notificationElement =  {
				type : notification.type,
				text : notification.text,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 5000);
		},

		themePreview: function(themeType) {
			this.previewTheme = ''
			setTimeout(() => {
				this.previewTheme = themeType
			  }, 250)
		},
		themePreviewClear: function() {
			setTimeout(() => {
				this.previewTheme = ''
			  }, 250)
		},

        hasFeature : function ( feature_name ) {
            var self = this;
            return self.license_tier_features.includes( feature_name );
        },

        checkFeedTypeTier : function( feedType, advancedFeedType = false ) {
            var self = this,
                typeTiers = {
                   'photos' : 'photos_albums_feeds',
                    'albums' : 'photos_albums_feeds',
                    'videos' : 'video_feeds',
                    'events' : 'events_feeds'
                },
                feedTypeTierIncluder = Object.keys( typeTiers ).includes( feedType ) ? self.hasFeature( typeTiers[feedType] ) : true;

                if ( !feedTypeTierIncluder && advancedFeedType && self.viewsActive.feedtypesPopup ) {
					self.activateView('feedtypesPopup');
				}
            return feedTypeTierIncluder;
        },

        checkFeedTemplateTier : function( feedTemplateEl ) {
            var self = this;
            if ( !self.hasFeature('feed_templates')  && self.viewsActive.feedtemplatesPopup ) {
                self.viewsActive.extensionsPopupElement = 'feedTemplate'
                self.activateView('feedtemplatesPopup');
			}else{
                self.chooseFeedTemplate(feedTemplateEl, true)
            }
        },

		checkFeedEventSourceiCalUrl : function( feed ) {
			let self = this,
				feedSettings = feed['settings'];
			if(feedSettings['type'] !== 'events'){
				return true;
			}
			let resp = false;
			if( Array.isArray( feedSettings['sources'] ) ){
				feedSettings['sources'].forEach( source => {
					resp = self.iCalURLs[source.account_id] !== undefined || (source?.account_type && source.account_type !== 'page');
				} )
			}else{
				let curSource = self.sourcesList.filter( source => {
					return feedSettings['sources'] === source.account_id;
				} )
				resp = self.iCalURLs[feedSettings['sources']] !== undefined || (curSource[0]?.account_type && curSource[0].account_type !== 'page');

			}
			return resp;
		},
		clickAddFeedEventSourceiCalUrl : function( feed ) {
			let self = this,
				feedSettings = feed['settings'];
			if(feedSettings['type'] !== 'events'){
				return true;
			}
			let source_id = false;
			if( Array.isArray( feedSettings['sources'] ) ){
				feedSettings['sources'].forEach( source => {
					source_id = source.account_id;
				} )

			}else{
				source_id = feedSettings['sources']
			}
			if(source_id !== false){
				self.chooseAccountId(source_id)
			}
		},

		checkSourceiCalUrl : function( source ) {
			return source.privilege !== 'events' || (source.privilege === 'events' && this.iCalURLs[source.account_id] !== undefined);
		},

        chooseAccountId : function( source_account_id, is_connect_page = false ) {
            let self = this;
			self.addIcalUrl.source_id = source_account_id;
			self.addIcalUrl.reconnectPage = is_connect_page;
			self.addIcalUrl.url = self.iCalURLs[source_account_id] !== undefined ? self.iCalURLs[source_account_id] : ''
            this.activateView('iCalUrlPopup')
            cffBuilder.$forceUpdate();
		},

        print_ical_url : function( source ) {
			return source.privilege === 'events' && this.iCalURLs[source.account_id] !== undefined ? this.iCalURLs[source.account_id] : ''
		},

        connectEventiCalUrl : function() {
			let self = this;

			if( self.checkNotEmpty(self.addIcalUrl.url) && self.checkNotEmpty(self.addIcalUrl.source_id) ) {
				self.addIcalUrl.loadingAjax = true;
				self.addIcalUrl.isError = false;
				self.addIcalUrl.success = false;
                self.addIcalUrl.errorMessage = '';

                let data = new FormData();
                data.append( 'action', 'cff_feed_saver_manager_add_events_ical_url' );
                data.append( 'nonce', this.nonce );
                data.append( 'ical_url', self.addIcalUrl.url );
                data.append( 'source_id', self.addIcalUrl.source_id );

                if( self.addIcalUrl.reconnectPage === true && self.checkNotEmpty(self.addIcalUrl.pageToken) ){
                    data.append( 'reconnect_page', true );
                    data.append( 'access_token', self.addIcalUrl.pageToken );
                }


                fetch(this.ajaxHandler, {
                    method: "POST",
                    credentials: 'same-origin',
                    body: data
                })
                .then(response => response.json())
                .then(data => {
    				self.addIcalUrl.loadingAjax = false;
                    self.iCalURLs = data.data.ical_urls;

                    if(data?.data?.sourcesList){
                        self.sourcesList  = data.data.sourcesList;
                    }

                    if ( data.success === false ) {
                        self.addIcalUrl.isError = true;
                        self.addIcalUrl.errorMessage = data.data.message;
        				self.addIcalUrl.success = false;
                    }else{
                        self.addIcalUrl.errorMessage = '';
                        self.addIcalUrl.isError = false;
        				self.addIcalUrl.success = true;
                        setTimeout(function() {
                            self.addIcalUrl.errorMessage = '';
                            self.activateView('iCalUrlPopup')
                            self.addIcalUrl.isError = false;
        				    self.addIcalUrl.success = false;
                        }, 3000);
                    }
                    return;
                });

			}

		},

		getShowEventsTimezoneNoticeType : function() {
			let settings = this.customizerFeedData.settings;
			if (
				(settings.eventstimezoneoffsetchanged === false || settings.eventstimezoneoffsetchanged === 'false') &&
				(settings.eventstimezoneoffset === true || settings.eventstimezoneoffset === 'true')
			) {
				this.showEventsTimezoneNoticeType = 'dismiss'
			}
			return this.showEventsTimezoneNoticeType;
		},

		openFixEventTimezoneIssue : function() {
			var self = this,
				individual_elements = self.customizerSidebarBuilder['settings'].sections.settings_advanced;
				self.customizerScreens.activeSection = 'settings_advanced';
				self.customizerScreens.activeSectionData= self.customizerSidebarBuilder['settings'].sections.settings_advanced;
				self.switchCustomizerSection('settings_advanced', individual_elements, false, false);
				cffBuilder.$forceUpdate();
		},

		dimissEventsTimezoneNotice : function() {
			this.customizerFeedData.settings.eventstimezoneoffsetchanged = true;
			this.showEventsTimezoneNotice = false;
			cffBuilder.$forceUpdate();
		}



	}

});


