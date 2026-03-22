document.addEventListener("DOMContentLoaded", () => {
    const boxes = document.querySelectorAll(".re-style-video-source-box");

    boxes.forEach((box) => {
        const typeInputs = box.querySelectorAll('input[name="re_style_video_source_type"]');
        const uploadWrap = box.querySelector(".re-style-video-source-upload");
        const externalWrap = box.querySelector(".re-style-video-source-external");
        const selectButton = box.querySelector(".re-style-select-video");
        const clearButton = box.querySelector(".re-style-clear-video");
        const attachmentField = box.querySelector('input[name="re_style_video_attachment_id"]');
        const uploadUrlField = box.querySelector("#re-style-video-upload-url");

        const updateVisibility = () => {
            const activeTypeInput = box.querySelector('input[name="re_style_video_source_type"]:checked');
            const activeType = activeTypeInput ? activeTypeInput.value : "upload";

            if (uploadWrap) {
                uploadWrap.style.display = activeType === "upload" ? "" : "none";
            }

            if (externalWrap) {
                externalWrap.style.display = activeType === "external" ? "" : "none";
            }
        };

        typeInputs.forEach((input) => {
            input.addEventListener("change", updateVisibility);
        });

        updateVisibility();

        if (selectButton && attachmentField && uploadUrlField && typeof wp !== "undefined" && wp.media) {
            let mediaFrame;

            selectButton.addEventListener("click", (event) => {
                event.preventDefault();

                if (!mediaFrame) {
                    mediaFrame = wp.media({
                        title: "Seleziona video",
                        button: { text: "Usa questo video" },
                        library: { type: "video" },
                        multiple: false,
                    });

                    mediaFrame.on("select", () => {
                        const selection = mediaFrame.state().get("selection").first();
                        const attachment = selection ? selection.toJSON() : null;

                        if (!attachment) {
                            return;
                        }

                        attachmentField.value = attachment.id || "";
                        uploadUrlField.value = attachment.url || "";

                        if (clearButton) {
                            clearButton.style.display = attachment.url ? "" : "none";
                        }
                    });
                }

                mediaFrame.open();
            });
        }

        if (clearButton && attachmentField && uploadUrlField) {
            clearButton.addEventListener("click", (event) => {
                event.preventDefault();
                attachmentField.value = "";
                uploadUrlField.value = "";
                clearButton.style.display = "none";
            });
        }
    });
});
