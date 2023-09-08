var GPO_GW_globals = {
    CookieVersion: "1.0",
    CookieName: "gpogw.goldprice.org",
    defaultChart: "http://goldprice.org/NewCharts/gold/images/gold_1d_o_USD_z.png",
    chart: "http://goldprice.org/NewCharts/gold/images/gold_1d_o_USD_z.png",
    curr_with_no_history: "BHD,DKK,EGP,HRK,HUF,ILS,JOD,KRW,LBP,LTL,LYD,MKD,MMK,MOP,NGN,NOK,NPR,PKR,QAR,RSD,SAR,THB,TWD,VND",
    history_years: "USD,30!AED,5!ARS,5!AUD,30!BRL,10!CAD,30!CHF,30!CNY,30!COP,5!EUR,10!GBP,30!HKD,30!IDR,20!INR,30!JPY,30!KWD,5!MXN,10!MYR,5!NZD,5!PHP,20!RUB,5!SEK,10!SGD,30!TRY,10!ZAR,30!"
};
function GPO_GW_InstallWidget() {
    try {
        var GPO_GW_test = document.getElementById("GPO_GW_Chart");
        if (GPO_GW_test != null) {
            GPO_GW_ResetGlobals();
            return;
        }
        var GPO_GW_div = document.getElementById("gold-price");
        var GPO_GW_defaults = GPO_GW_div.getAttribute("data-gold_price").split("-");
        var GPO_GW_cur = GPO_GW_defaults[0];
        var GPO_GW_weight = GPO_GW_defaults[1];
        var GPO_GW_time = GPO_GW_defaults[2];
        var GPO_GW_html = "<div style=\"text-align: center;\"><img class=\"w-100\" id=\"GPO_GW_Chart\" alt=\"GoldPrice.Org\" src=\"GPO_GW_DefaultImage\"/></div><div style=\"text-align: center;\"><select name=\"GPO_GW_Currency\" id=\"GPO_GW_Currency\" onchange=\"GPO_GW_Changed();\"><option value=\"USD\">USD</option><option value=\"MYR\">MYR</option></select><select name=\"GPO_GW_Weight\" id=\"GPO_GW_Weight\" onchange=\"GPO_GW_Changed();\" style=\"display: inline-block;\"><option value=\"o\">oz</option><option value=\"g\">g</option><option value=\"k\">kg</option></select><select name=\"GPO_GW_Time\" id=\"GPO_GW_Time\" onchange=\"GPO_GW_Changed();\"><option value=\"1d\">24 Hours</option><option value=\"30_day\">30 Days</option><option value=\"60_day\">60 Days</option><option value=\"6_month\">6 Months</option><option value=\"1_year\">1 Year</option><option value=\"2_year\">2 Years</option><option value=\"5_year\">5 Years</option><option value=\"10_year\">10 Years</option><option value=\"15_year\">15 Years</option><option value=\"20_year\">20 Years</option><option value=\"30_year\">30 Years</option><option value=\"all_data\">All Data</option></select></div><div style=\"margin: 5px;font-size: 10px;text-align: right;\"><a style=\"text-align: right;text-decoration: none;\" href=\"http://goldprice.org/gold-price-charts.html\" target=\"_blank\">Add to site</a></div>";
        GPO_GW_html = GPO_GW_html.replace("=\"" + GPO_GW_cur + "\">", "=\"" + GPO_GW_cur + "\" selected=\"selected\">");
        GPO_GW_html = GPO_GW_html.replace("=\"" + GPO_GW_weight + "\">", "=\"" + GPO_GW_weight + "\" selected=\"selected\">");
        GPO_GW_html = GPO_GW_html.replace("=\"" + GPO_GW_time + "\">", "=\"" + GPO_GW_time + "\" selected=\"selected\">");
        GPO_GW_GetImageURL(GPO_GW_cur, GPO_GW_weight, GPO_GW_time);
        GPO_GW_html = GPO_GW_html.replace("GPO_GW_DefaultImage", GPO_GW_globals.chart);
        GPO_GW_div.innerHTML = GPO_GW_html
        var GPO_GW_href = GPO_GW_div.parentElement.children[0].children[0];
        GPO_GW_href.setAttribute("href", "http://goldprice.org");
        GPO_GW_href.innerHTML="GoldPrice.org";
        GPO_GW_Init();
    }
    catch (Error) {
    }
}
function GPO_GW_ResetGlobals()
{
    var GPO_GW_cur=  document.getElementById("GPO_GW_Currency").value;
    var GPO_GW_weight = document.getElementById("GPO_GW_Weight").value;
    var GPO_GW_time = document.getElementById("GPO_GW_Time").value;
    GPO_GW_GetImageURL(GPO_GW_cur, GPO_GW_weight, GPO_GW_time);
}
function GPO_GW_GetImageURL(cur, weight, time) {
    try {
        if (time == "1d") {
            if (cur == "TRY")
                cur = "TRL";
            if (cur == "RUB")
                cur = "RUR";
            var url = "http://goldprice.org/NewCharts/gold/images/gold_1d_" + weight + "_" + cur + "_z.png";
            GPO_GW_globals.chart = url;
            GPO_GW_globals.defaultChart = url;
        }
        else {
            GPO_GW_GetHistoryX(cur, weight, time);
        }
    }
    catch (Error) {
        GPO_GW_globals.chart = GPO_GW_globals.defaultChart;
    }
}
function GPO_GW_GetHistoryX(cur, weight, time) {
    try {
        if (GPO_GW_globals.curr_with_no_history.indexOf(cur) >= 0) {
            GPO_GW_globals.chart = "http://goldprice.org/comming_soon_top_left.png";
            return;
        }
        if (!GPO_GW_CheckExists(time, cur)) {
            time = "all_data";
        }
        var filename = "_" + time + "_" + weight + "_" + cur.toLowerCase() + "_x.png";
        var url = "http://goldprice.org/NewCharts/gold/images/" + "gold" + filename;
        GPO_GW_globals.chart = url;
        GPO_GW_globals.defaultChart = url;
    }
    catch (Error) {
        GPO_GW_globals.chart = GPO_GW_globals.defaultChart;
    }
}

function GPO_GW_Init() {
    try {
        GPO_GW_GetCookie();
        setInterval("GPO_GW_Refresh()", 60 * 1000);
    }
    catch (Error) {
    }
}
function GPO_GW_GetCookie() {
    try {
        var cookieString = GPO_GW_Cookie.get(GPO_GW_globals.CookieName);
        if (cookieString == null) {
            return;
        }
        var values = cookieString.split(",");
        var cver = parseFloat(values[0]);
        if (cver == 1.0) {
            document.getElementById("GPO_GW_Currency").value = values[1];
            document.getElementById("GPO_GW_Weight").value = values[2];
            document.getElementById("GPO_GW_Time").value = values[3];
        }
        GPO_GW_Changed();
    }
    catch (Error) {
    }
}
function GPO_GW_SaveCookie() {
    try {
        var temp = GPO_GW_globals.CookieVersion +
            "," + document.getElementById("GPO_GW_Currency").value +
            "," + document.getElementById("GPO_GW_Weight").value +
            "," + document.getElementById("GPO_GW_Time").value;
        GPO_GW_Cookie.set(GPO_GW_globals.CookieName, temp);
    }
    catch (Error) {
    }
}
GPO_GW_Cookie = {
    get: function (key) {
        var aCookie = document.cookie.split("; ");
        for (var i = 0; i < aCookie.length; i++) {
            var aCrumb = aCookie[i].split("=");
            if (key == aCrumb[0])
                return unescape(aCrumb[1]);
        }
        return null;
    },
    set: function (key, value) {
        var expires_date = new Date();
        expires_date.setFullYear(2020, 11, 12);
        var path = window.location.pathname.replace(/(\/)[^\/]*$/, '$1');
        var domain = window.location.hostname;
        var cookieStr = key + "=" + escape(value) + ";expires=" + expires_date.toGMTString() + ";path=" + path + ";domain=" + domain;
        document.cookie = cookieStr;
        return document.cookie;
    }
}
function GPO_GW_Changed() {
    try {
        var time = document.getElementById("GPO_GW_Time").value;
        var cur = document.getElementById("GPO_GW_Currency").value;
        if (cur == null)
            cur = "USD";
        var img = document.getElementById("GPO_GW_Chart");
        var weight = document.getElementById("GPO_GW_Weight").value;
        if (time == "1d") {
            if (cur == "TRY")
                cur = "TRL";
            if (cur == "RUB")
                cur = "RUR";
            var url = "http://goldprice.org/NewCharts/gold/images/gold_1d_" + weight + "_" + cur + "_z.png";
            GPO_GW_globals.chart = url;
            img.src = url + "?" + Math.random();;
        }
        else {
            GPO_GW_GetHistory(cur, weight, time, img);
        }
    }
    catch (Error) {
        var img = document.getElementById("GPO_GW_Chart");
        img.src = GPO_GW_globals.defaultChart
    }
    GPO_GW_SaveCookie();
}
function GPO_GW_GetHistory(cur, weight, time, img) {
    try {
        if (GPO_GW_globals.curr_with_no_history.indexOf(cur) >= 0) {
            img.src = "http://goldprice.org/comming_soon_top_left.png";
            return;
        }
        if (!GPO_GW_CheckExists(time, cur)) {
            document.getElementById("GPO_GW_Time").value = "all_data";
            time = "all_data";
        }
        var filename = "_" + time + "_" + weight + "_" + cur.toLowerCase() + "_x.png";
        var url = "http://goldprice.org/NewCharts/gold/images/" + "gold" + filename;
        img.src = url + "?" + Math.random();
        GPO_GW_globals.chart = url;
    }
    catch (Error) {
        var img = document.getElementById("GPO_GW_Chart");
        img.src = defaultChartRight
    }
}
function GPO_GW_CheckExists(time, curr) {
    try {
        if (time.indexOf("_year") < 0) return true;

        var yearSelected = parseInt(time.replace("_year", ""));
        var yearMax = parseInt(GPO_GW_globals.history_years.substr(GPO_GW_globals.history_years.indexOf(curr) + 4, 2));
        if (yearSelected <= yearMax) {
            return true;
        }
        else {
            return false;
        }
    }
    catch (Error) {
        return false;
    }
}
function GPO_GW_Refresh() {
    try {
        img = document.getElementById("GPO_GW_Chart");
        if (img.src.indexOf("1d") > 0) {
            img.src = GPO_GW_globals.chart + "?" + Math.random();
        }
    }
    catch (Error) {
    }
}
GPO_GW_InstallWidget();