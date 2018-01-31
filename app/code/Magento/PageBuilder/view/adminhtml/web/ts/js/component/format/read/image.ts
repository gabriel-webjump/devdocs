/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

import {DataObject} from "../../data-store";
import ReadInterface from "../read-interface";
import {decodeUrl} from "../../../utils/image";

export default class Image implements ReadInterface {

    /**
     * Read heading type and title from the element
     *
     * @param element HTMLElement
     * @returns {Promise<any>}
     */
    public read(element: HTMLElement): Promise<any> {
        const response: DataObject = {
            alt: element.querySelector("img:nth-child(1)").getAttribute("alt"),
            image: decodeUrl(
                element.querySelector("img:nth-child(1)").getAttribute("src")
            ),
            lightbox: (!!element.querySelector("a.pagebuilder-lightbox")) ? "Yes" : "No",
            mobile_image: "",
            show_caption: (!!element.querySelector("figcaption")) ? "Yes" : "No",
            title_tag: element.querySelector("a").getAttribute("title"),
        };

        // Detect if there is a mobile image and update the response
        if (element.querySelector("img:nth-child(2)")
            && element.querySelector("img:nth-child(2)").getAttribute("src")
        ) {
            response.mobile_image = decodeUrl(
                element.querySelector("img:nth-child(2)").getAttribute("src")
            );
        }

        return Promise.resolve(response);
    }
}
