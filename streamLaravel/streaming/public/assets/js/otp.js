document.addEventListener("DOMContentLoaded", function () {
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(addedNode => {
                    if (addedNode.nodeType === Node.ELEMENT_NODE) {
                        if (addedNode.querySelector('#otp-form')) {
                            attachOtpEventListener();
                            observer.disconnect();
                            return;
                        }
                    }
                });
            }
        });
    });

    function attachOtpEventListener() {
        const otpInputs = document.querySelectorAll(".otp-input");
        otpInputs.forEach((input, index) => {
            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && input.value === "") {
                    if (index !== 0) otpInputs[index - 1].focus();
                }
            });
            input.addEventListener("input", (e) => {
                const value = e.target.value;
                if (value.length > 1) {
                    const values = value.split('');
                    for (let i = 0; i < otpInputs.length; i++) {
                        otpInputs[i].value = values[i] || '';
                    }
                } else {
                    if (value !== "" && index !== otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                }
            });

            input.addEventListener("paste", (e) => {
                const pasteData = e.clipboardData.getData('text').split('');
                otpInputs.forEach((input, index) => {
                    input.value = pasteData[index] || '';
                });
                e.preventDefault();
            });
        });
    }

    observer.observe(document.getElementById('rma-container'), {
        childList: true,
        subtree: true
    });
});
