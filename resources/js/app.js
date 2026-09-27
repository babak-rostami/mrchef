import "./bootstrap";
import "./component/modal";
import "./user/auth";
import "./page/menu";
import "./page/search";
import { resumePendingAuthAction } from "./utils/require-login";
// import "./utils/darkmode";

// اگه قبل از لاگین یه فرم یا اکشنی (مثل ثبت نظر) معلق مونده بود، الان که
// کاربر لاگین کرده و صفحه رفرش شده، خودش دوباره اجرا میشه.
document.addEventListener("DOMContentLoaded", resumePendingAuthAction);
