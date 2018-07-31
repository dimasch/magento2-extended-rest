# Rest Api for Magento2 + vue storefront

<h2>New hotpoints for Rest Api</h2>

GET /V1/kt/shippingmethods

<h2>Edit hotpoint for Rest Api</h2>

GET /V1/products - add on CustomAttributes - "swatch_image" [You may add from Products - Catalog - Colors. Colors configuration on Stores - Attributes - Product - Color]
GET /V1/configurable-products/{sku}/children - customAttributes - swatchImage [You may see path of image or #RGB code of color]
GET /V1/kt/products/attributes/{attributeCode} - options - add swatch_image if on options that include (else null) - we stay it on future debugging
GET /V1/kt/products/attributes/ - for add to filters swatch_images on color attribute (on array of options you may see path or #RGB of color)
        
v.1.0.2 
GET /V1/configurable-products/{sku}/children - customAttributes - Stocks [You may see array of stocks with 3 attributes - stock_id, name, qty]




