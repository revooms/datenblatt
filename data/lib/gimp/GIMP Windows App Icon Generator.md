```scm
;icon-for-Godot.scm
;===========================

;Modified for Godot by Giuseppe Pica (jospic) for replacing missing Windows icon of .exe file from Godot Game Engine exported resources, fork from iconify by Giuseppe Bilotta

;===========================
;
;
; It converts an image into a Windows/Macintosh icon
(define (script-fu-icon-for-Godot img drawable)
; Create a new image. It's also easy to add
; 128x128 Macintosh icons, or other sizes
(let* (
       (new-img (car (gimp-image-new 256 256 0)))
       (new-name 0)
       (work-layer 0)
       (big-layer 0)
       (layer-x 0)
       (layer-y 0)
       (max-dim 0)
       (temp-layer 0)

       (temp-img 0)
       (layers 0)
       (layernum 0)
       (layers-array 0)
       (layer 0)
       (eigth-bit 0)
       (four-bit 0)
       )

(set! new-name
(append
(butlast
(strbreakup (car (gimp-image-get-filename img)) ".")
)
'(".ico")
)
)
(set! new-name (eval (cons string-append new-name)))
(gimp-image-set-filename new-img new-name)

; Create a new layer
(set! work-layer (car (gimp-layer-new-from-drawable drawable new-img)))

; Give it a name
(gimp-layer-set-name work-layer "Work layer")

; Add the new layer to the new image
(gimp-image-add-layer new-img work-layer 0)

; Autocrop the layer
(plug-in-autocrop-layer 1 new-img work-layer)

; Now, resize the layer so that it is square,
; by making the shorter dimension the same as
; the longer one. The layer content is centered.
(set! layer-x (car (gimp-drawable-width work-layer)))
(set! layer-y (car (gimp-drawable-height work-layer)))
(set! max-dim (max layer-x layer-y))
(gimp-layer-resize work-layer max-dim max-dim (/ (- max-dim layer-x) 2) (/ (- max-dim layer-y) 2))

; Move the layer to the origin of the image
(gimp-layer-set-offsets work-layer 0 0)

; Now, we create as many layers as needed, resizing to
; 16x16, 32x32, 48x48, 128x128, 256x256

(define (resize-to-dim dim)

(set! temp-layer (car (gimp-layer-copy work-layer 0)))
(gimp-layer-set-name temp-layer "Work layer")
(gimp-image-add-layer new-img temp-layer 0)
(gimp-drawable-transform-scale temp-layer 0 0 dim dim 0 2 1 3 0)
)

; We don't do the biggest size at this moment
(mapcar resize-to-dim '(16 32 48 64 128 256))

; Create the big layer, but do not add it yet
(set! big-layer (car (gimp-layer-copy work-layer 0)))
(gimp-layer-set-name big-layer "Main")

; We can now get rid of the working layer
(gimp-image-remove-layer new-img work-layer)

(define (palettize-image num)
(set! temp-img (car (gimp-image-duplicate new-img)))
(gimp-image-convert-indexed temp-img 0 0 num TRUE TRUE "")
temp-img)
(define (plop-image temp-img)
(set! layers (gimp-image-get-layers temp-img))
(set! layernum (car layers))
(set! layers-array (cadr layers))
(while (> layernum 0)
(set! layer (car
(gimp-layer-new-from-drawable
(aref layers-array (- layernum 1)) new-img)
)
)
(gimp-image-add-layer new-img layer 0)
(set! layernum (- layernum 1))
)
(gimp-image-delete temp-img)
)

; The 256 color image
;(set! eigth-bit (palettize-image 256))
; RC: Use 15 instead of 16 for the transparency
;(set! four-bit (palettize-image 15))

; Now we put the new layers back in the original image
;(plop-image eigth-bit)
;(plop-image four-bit)

; We add the big version
(gimp-image-add-layer new-img big-layer 0)
(gimp-drawable-transform-scale big-layer 0 0 256 256 0 2 1 3 0)

; We display the new image
(gimp-display-new new-img)

; And we flush the display
(gimp-displays-flush)

))

; TODO the plugin currently only works with truecolor images
; it could be extended to work with palettized images, thus only creating
; layers for depths up to the current image depth
(script-fu-register "script-fu-icon-for-Godot"
"<Image>/Script-Fu/Utils/icon-for-Godot"
"Use the current layer of the current image to create a multi-sized, multi-depth Windows icon file"
"Giuseppe Pica (jospic), modified for Godot"
"Giuseppe Bilotta, Fixed By Roland Clobus for gimp 2.8+"
"20051021"
"RGB*"
SF-IMAGE "Image to iconify" 0
SF-DRAWABLE "Layer to iconify" 0)
```