<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0062)https://mallofasia-arena.com/event-detail/THE+WEEKND+ASIA/7027 -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>PHP notice</title>

<style type="text/css">
/*<![CDATA[*/
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;margin:0;padding:0;}
body{line-height:1;}
ol,ul{list-style:none;}
blockquote,q{quotes:none;}
blockquote:before,blockquote:after,q:before,q:after{content:none;}
:focus{outline:0;}
ins{text-decoration:none;}
del{text-decoration:line-through;}
table{border-collapse:collapse;border-spacing:0;}

body {
	font: normal 9pt "Verdana";
	color: #000;
	background: #fff;
}

h1 {
	font: normal 18pt "Verdana";
	color: #f00;
	margin-bottom: .5em;
}

h2 {
	font: normal 14pt "Verdana";
	color: #800000;
	margin-bottom: .5em;
}

h3 {
	font: bold 11pt "Verdana";
}

pre {
	font: normal 11pt Menlo, Consolas, "Lucida Console", Monospace;
}

pre span.error {
	display: block;
	background: #fce3e3;
}

pre span.ln {
	color: #999;
	padding-right: 0.5em;
	border-right: 1px solid #ccc;
}

pre span.error-ln {
	font-weight: bold;
}

.container {
	margin: 1em 4em;
}

.version {
	color: gray;
	font-size: 8pt;
	border-top: 1px solid #aaa;
	padding-top: 1em;
	margin-bottom: 1em;
}

.message {
	color: #000;
	padding: 1em;
	font-size: 11pt;
	background: #f3f3f3;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	margin-bottom: 1em;
	line-height: 160%;
}

.source {
	margin-bottom: 1em;
}

.code pre {
	background-color: #ffe;
	margin: 0.5em 0;
	padding: 0.5em;
	line-height: 125%;
	border: 1px solid #eee;
}

.source .file {
	margin-bottom: 1em;
	font-weight: bold;
}

.traces {
	margin: 2em 0;
}

.trace {
	margin: 0.5em 0;
	padding: 0.5em;
}

.trace.app {
	border: 1px dashed #c00;
}

.trace .number {
	text-align: right;
	width: 2em;
	padding: 0.5em;
}

.trace .content {
	padding: 0.5em;
}

.trace .plus,
.trace .minus {
	display:inline;
	vertical-align:middle;
	text-align:center;
	border:1px solid #000;
	color:#000;
	font-size:10px;
	line-height:10px;
	margin:0;
	padding:0 1px;
	width:10px;
	height:10px;
}

.trace.collapsed .minus,
.trace.expanded .plus,
.trace.collapsed pre {
	display: none;
}

.trace-file {
	cursor: pointer;
	padding: 0.2em;
}

.trace-file:hover {
	background: #f0ffff;
}
/*]]>*/
</style>
</head>

<body>
<div class="container">
	<h1>PHP notice</h1>

	<p class="message">
		Undefined offset: 0	</p>

	<div class="source">
		<p class="file">/var/www/html/arena/protected/models/API.php(1742)</p>
		<div class="code"><pre><span class="ln">1730</span>         $eventData = false;
<span class="ln">1731</span>         if($id != null)
<span class="ln">1732</span>         {
<span class="ln">1733</span>             //this API call is broken - DL4515
<span class="ln">1734</span>             // $dataArr = array('type'=&gt;'GetActiveEventsFullbyID','id'=&gt;$id);
<span class="ln">1735</span>             // $call = self::call($dataArr);
<span class="ln">1736</span>             $dataArr = array('type'=&gt;'GetActiveEventsFull');
<span class="ln">1737</span>             $call = self::call($dataArr, $toarray, $returnError);        
<span class="ln">1738</span>                         
<span class="ln">1739</span>             if(!$call['error'])
<span class="ln">1740</span>             {
<span class="ln">1741</span>                 $call['data'] = self::customFilter($call['data'],'event_id',array($id));
<span class="error"><span class="ln error-ln">1742</span>                 $eventData = $call['data'][0];
</span><span class="ln">1743</span>                 if($filterByVenue)
<span class="ln">1744</span>                 {
<span class="ln">1745</span>                     $venueFilter = Setting::retriveVenueIDs();
<span class="ln">1746</span>                     if($returnError)
<span class="ln">1747</span>                     {
<span class="ln">1748</span>                         if(!self::flexiValidation($eventData,'event_venue_id',$venueFilter, $returnError))
<span class="ln">1749</span>                         {
<span class="ln">1750</span>                             $eventData = false;
<span class="ln">1751</span>                         }
<span class="ln">1752</span>                     }
<span class="ln">1753</span>                     else
<span class="ln">1754</span>                     {
</pre></div>	</div>

	<div class="traces">
		<h2>Stack Trace</h2>
				<table style="width:100%;">
						<tbody><tr class="trace app expanded">
			<td class="number">
				#0			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/protected/controllers/ApiController.php(108): <strong>API</strong>::<strong>returnEventData</strong>("7027")				</div>

				<div class="code"><pre><span class="ln">103</span>     //view detailed event per ID
<span class="ln">104</span>     public function actionEventDetail($id)
<span class="ln">105</span>     {
<span class="ln">106</span>         $this-&gt;layout = '//layouts/moa_column2';
<span class="ln">107</span>         
<span class="error"><span class="ln error-ln">108</span>         $eventData = API::returnEventData($id);
</span><span class="ln">109</span>         $buildData = API::generateEventData($eventData);
<span class="ln">110</span>         
<span class="ln">111</span>         if($eventData-&gt;event_venue_id == 258)
<span class="ln">112</span>         {
<span class="ln">113</span>             $this-&gt;active = 'foodAndMerchandise';
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#1			</td>
			<td class="content">
				<div class="trace-file">
										&nbsp;unknown(0): <strong>ApiController</strong>-&gt;<strong>actionEventDetail</strong>("7027")				</div>

							</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#2			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/actions/CAction.php(108): <strong>ReflectionMethod</strong>-&gt;<strong>invokeArgs</strong>(ApiController, array("7027"))				</div>

				<div class="code"><pre><span class="ln">103</span>             elseif($param-&gt;isDefaultValueAvailable())
<span class="ln">104</span>                 $ps[]=$param-&gt;getDefaultValue();
<span class="ln">105</span>             else
<span class="ln">106</span>                 return false;
<span class="ln">107</span>         }
<span class="error"><span class="ln error-ln">108</span>         $method-&gt;invokeArgs($object,$ps);
</span><span class="ln">109</span>         return true;
<span class="ln">110</span>     }
<span class="ln">111</span> }
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#3			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/actions/CInlineAction.php(47): <strong>CAction</strong>-&gt;<strong>runWithParamsInternal</strong>(ApiController, ReflectionMethod, array("title" =&gt; "THE WEEKND ASIA", "id" =&gt; "7027"))				</div>

				<div class="code"><pre><span class="ln">42</span>     {
<span class="ln">43</span>         $methodName='action'.$this-&gt;getId();
<span class="ln">44</span>         $controller=$this-&gt;getController();
<span class="ln">45</span>         $method=new ReflectionMethod($controller, $methodName);
<span class="ln">46</span>         if($method-&gt;getNumberOfParameters()&gt;0)
<span class="error"><span class="ln error-ln">47</span>             return $this-&gt;runWithParamsInternal($controller, $method, $params);
</span><span class="ln">48</span>         else
<span class="ln">49</span>             return $controller-&gt;$methodName();
<span class="ln">50</span>     }
<span class="ln">51</span> 
<span class="ln">52</span> }
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#4			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CController.php(308): <strong>CInlineAction</strong>-&gt;<strong>runWithParams</strong>(array("title" =&gt; "THE WEEKND ASIA", "id" =&gt; "7027"))				</div>

				<div class="code"><pre><span class="ln">303</span>     {
<span class="ln">304</span>         $priorAction=$this-&gt;_action;
<span class="ln">305</span>         $this-&gt;_action=$action;
<span class="ln">306</span>         if($this-&gt;beforeAction($action))
<span class="ln">307</span>         {
<span class="error"><span class="ln error-ln">308</span>             if($action-&gt;runWithParams($this-&gt;getActionParams())===false)
</span><span class="ln">309</span>                 $this-&gt;invalidActionParams($action);
<span class="ln">310</span>             else
<span class="ln">311</span>                 $this-&gt;afterAction($action);
<span class="ln">312</span>         }
<span class="ln">313</span>         $this-&gt;_action=$priorAction;
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#5			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/filters/CFilterChain.php(133): <strong>CController</strong>-&gt;<strong>runAction</strong>(CInlineAction)				</div>

				<div class="code"><pre><span class="ln">128</span>             $filter=$this-&gt;itemAt($this-&gt;filterIndex++);
<span class="ln">129</span>             Yii::trace('Running filter '.($filter instanceof CInlineFilter ? get_class($this-&gt;controller).'.filter'.$filter-&gt;name.'()':get_class($filter).'.filter()'),'system.web.filters.CFilterChain');
<span class="ln">130</span>             $filter-&gt;filter($this);
<span class="ln">131</span>         }
<span class="ln">132</span>         else
<span class="error"><span class="ln error-ln">133</span>             $this-&gt;controller-&gt;runAction($this-&gt;action);
</span><span class="ln">134</span>     }
<span class="ln">135</span> }</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#6			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/filters/CFilter.php(40): <strong>CFilterChain</strong>-&gt;<strong>run</strong>()				</div>

				<div class="code"><pre><span class="ln">35</span>      */
<span class="ln">36</span>     public function filter($filterChain)
<span class="ln">37</span>     {
<span class="ln">38</span>         if($this-&gt;preFilter($filterChain))
<span class="ln">39</span>         {
<span class="error"><span class="ln error-ln">40</span>             $filterChain-&gt;run();
</span><span class="ln">41</span>             $this-&gt;postFilter($filterChain);
<span class="ln">42</span>         }
<span class="ln">43</span>     }
<span class="ln">44</span> 
<span class="ln">45</span>     /**
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#7			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CController.php(1145): <strong>CFilter</strong>-&gt;<strong>filter</strong>(CFilterChain)				</div>

				<div class="code"><pre><span class="ln">1140</span>      */
<span class="ln">1141</span>     public function filterAccessControl($filterChain)
<span class="ln">1142</span>     {
<span class="ln">1143</span>         $filter=new CAccessControlFilter;
<span class="ln">1144</span>         $filter-&gt;setRules($this-&gt;accessRules());
<span class="error"><span class="ln error-ln">1145</span>         $filter-&gt;filter($filterChain);
</span><span class="ln">1146</span>     }
<span class="ln">1147</span> 
<span class="ln">1148</span>     /**
<span class="ln">1149</span>      * Returns a persistent page state value.
<span class="ln">1150</span>      * A page state is a variable that is persistent across POST requests of the same page.
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#8			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/filters/CInlineFilter.php(58): <strong>CController</strong>-&gt;<strong>filterAccessControl</strong>(CFilterChain)				</div>

				<div class="code"><pre><span class="ln">53</span>      * @param CFilterChain $filterChain the filter chain that the filter is on.
<span class="ln">54</span>      */
<span class="ln">55</span>     public function filter($filterChain)
<span class="ln">56</span>     {
<span class="ln">57</span>         $method='filter'.$this-&gt;name;
<span class="error"><span class="ln error-ln">58</span>         $filterChain-&gt;controller-&gt;$method($filterChain);
</span><span class="ln">59</span>     }
<span class="ln">60</span> }
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#9			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/filters/CFilterChain.php(130): <strong>CInlineFilter</strong>-&gt;<strong>filter</strong>(CFilterChain)				</div>

				<div class="code"><pre><span class="ln">125</span>     {
<span class="ln">126</span>         if($this-&gt;offsetExists($this-&gt;filterIndex))
<span class="ln">127</span>         {
<span class="ln">128</span>             $filter=$this-&gt;itemAt($this-&gt;filterIndex++);
<span class="ln">129</span>             Yii::trace('Running filter '.($filter instanceof CInlineFilter ? get_class($this-&gt;controller).'.filter'.$filter-&gt;name.'()':get_class($filter).'.filter()'),'system.web.filters.CFilterChain');
<span class="error"><span class="ln error-ln">130</span>             $filter-&gt;filter($this);
</span><span class="ln">131</span>         }
<span class="ln">132</span>         else
<span class="ln">133</span>             $this-&gt;controller-&gt;runAction($this-&gt;action);
<span class="ln">134</span>     }
<span class="ln">135</span> }</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#10			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CController.php(291): <strong>CFilterChain</strong>-&gt;<strong>run</strong>()				</div>

				<div class="code"><pre><span class="ln">286</span>             $this-&gt;runAction($action);
<span class="ln">287</span>         else
<span class="ln">288</span>         {
<span class="ln">289</span>             $priorAction=$this-&gt;_action;
<span class="ln">290</span>             $this-&gt;_action=$action;
<span class="error"><span class="ln error-ln">291</span>             CFilterChain::create($this,$action,$filters)-&gt;run();
</span><span class="ln">292</span>             $this-&gt;_action=$priorAction;
<span class="ln">293</span>         }
<span class="ln">294</span>     }
<span class="ln">295</span> 
<span class="ln">296</span>     /**
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#11			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CController.php(265): <strong>CController</strong>-&gt;<strong>runActionWithFilters</strong>(CInlineAction, array("accessControl"))				</div>

				<div class="code"><pre><span class="ln">260</span>         {
<span class="ln">261</span>             if(($parent=$this-&gt;getModule())===null)
<span class="ln">262</span>                 $parent=Yii::app();
<span class="ln">263</span>             if($parent-&gt;beforeControllerAction($this,$action))
<span class="ln">264</span>             {
<span class="error"><span class="ln error-ln">265</span>                 $this-&gt;runActionWithFilters($action,$this-&gt;filters());
</span><span class="ln">266</span>                 $parent-&gt;afterControllerAction($this,$action);
<span class="ln">267</span>             }
<span class="ln">268</span>         }
<span class="ln">269</span>         else
<span class="ln">270</span>             $this-&gt;missingAction($actionID);
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#12			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CWebApplication.php(282): <strong>CController</strong>-&gt;<strong>run</strong>("eventDetail")				</div>

				<div class="code"><pre><span class="ln">277</span>         {
<span class="ln">278</span>             list($controller,$actionID)=$ca;
<span class="ln">279</span>             $oldController=$this-&gt;_controller;
<span class="ln">280</span>             $this-&gt;_controller=$controller;
<span class="ln">281</span>             $controller-&gt;init();
<span class="error"><span class="ln error-ln">282</span>             $controller-&gt;run($actionID);
</span><span class="ln">283</span>             $this-&gt;_controller=$oldController;
<span class="ln">284</span>         }
<span class="ln">285</span>         else
<span class="ln">286</span>             throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
<span class="ln">287</span>                 array('{route}'=&gt;$route===''?$this-&gt;defaultController:$route)));
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#13			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/web/CWebApplication.php(141): <strong>CWebApplication</strong>-&gt;<strong>runController</strong>("api/eventDetail")				</div>

				<div class="code"><pre><span class="ln">136</span>             foreach(array_splice($this-&gt;catchAllRequest,1) as $name=&gt;$value)
<span class="ln">137</span>                 $_GET[$name]=$value;
<span class="ln">138</span>         }
<span class="ln">139</span>         else
<span class="ln">140</span>             $route=$this-&gt;getUrlManager()-&gt;parseUrl($this-&gt;getRequest());
<span class="error"><span class="ln error-ln">141</span>         $this-&gt;runController($route);
</span><span class="ln">142</span>     }
<span class="ln">143</span> 
<span class="ln">144</span>     /**
<span class="ln">145</span>      * Registers the core application components.
<span class="ln">146</span>      * This method overrides the parent implementation by registering additional core components.
</pre></div>			</td>
		</tr>
						<tr class="trace core collapsed">
			<td class="number">
				#14			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/yii-framework/yii-1.1.14.f0fee9/framework/base/CApplication.php(180): <strong>CWebApplication</strong>-&gt;<strong>processRequest</strong>()				</div>

				<div class="code"><pre><span class="ln">175</span>     public function run()
<span class="ln">176</span>     {
<span class="ln">177</span>         if($this-&gt;hasEventHandler('onBeginRequest'))
<span class="ln">178</span>             $this-&gt;onBeginRequest(new CEvent($this));
<span class="ln">179</span>         register_shutdown_function(array($this,'end'),0,false);
<span class="error"><span class="ln error-ln">180</span>         $this-&gt;processRequest();
</span><span class="ln">181</span>         if($this-&gt;hasEventHandler('onEndRequest'))
<span class="ln">182</span>             $this-&gt;onEndRequest(new CEvent($this));
<span class="ln">183</span>     }
<span class="ln">184</span> 
<span class="ln">185</span>     /**
</pre></div>			</td>
		</tr>
						<tr class="trace app expanded">
			<td class="number">
				#15			</td>
			<td class="content">
				<div class="trace-file">
											<div class="plus">+</div>
						<div class="minus">–</div>
										&nbsp;/var/www/html/arena/index.php(13): <strong>CApplication</strong>-&gt;<strong>run</strong>()				</div>

				<div class="code"><pre><span class="ln">08</span> defined('YII_DEBUG') or define('YII_DEBUG',true);
<span class="ln">09</span> // specify how many levels of call stack should be shown in each log message
<span class="ln">10</span> defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
<span class="ln">11</span> 
<span class="ln">12</span> require_once($yii);
<span class="error"><span class="ln error-ln">13</span> Yii::createWebApplication($config)-&gt;run();
</span></pre></div>			</td>
		</tr>
				</tbody></table>
	</div>

	<div class="version">
		2018-12-10 14:50:06 Apache/2.2.15 (CentOS) <a href="http://www.yiiframework.com/">Yii Framework</a>/1.1.14	</div>
</div>

<script type="text/javascript">
/*<![CDATA[*/
var traceReg = new RegExp("(^|\\s)trace-file(\\s|$)");
var collapsedReg = new RegExp("(^|\\s)collapsed(\\s|$)");

var e = document.getElementsByTagName("div");
for(var j=0,len=e.length;j<len;j++){
	if(traceReg.test(e[j].className)){
		e[j].onclick = function(){
			var trace = this.parentNode.parentNode;
			if(collapsedReg.test(trace.className))
				trace.className = trace.className.replace("collapsed", "expanded");
			else
				trace.className = trace.className.replace("expanded", "collapsed");
		}
	}
}
/*]]>*/
</script>



</body></html>