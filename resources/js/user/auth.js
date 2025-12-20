if (window.isGuest) {
    import("./check-email");
    import("./register");
    import("./login");
    import("./forgot");
    if (page !== "undefined" && page === "reset-password") {
        import("./reset-password");
    }
}
