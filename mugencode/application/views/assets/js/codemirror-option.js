var colors = [ 'red', 'blue', 'white' ];

      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {


        lineNumbers: true,
        lineWrapping: true,
        matchBrackets: true,
        matchTags: {bothTags: true},
        mode: $("#data-type-extention").attr("ext"),
        indentUnit: 4,
        indentWithTabs: true,
        autoCloseTags: true,
        scrollbarStyle: "simple",
        gutters: ["CodeMirror-lint-markers"],
        styleActiveLine: true,
        value: "",
        extraKeys: {

            "Ctrl-S": function(){
              save_project();
            },
            
            "Ctrl-Space": "autocomplete",

            "Ctrl-J": "toMatchingTag",

            'Ctrl-K' : function (cm, event) {
              editor.state.colorpicker.popup_color_picker();
            },

            'Ctrl-Q' : function(){
              var ext_name = $("#active-data").html();
              var get_class = ext_name+"-tabs";
              var get_path = $("."+get_class).attr("place");

              $("#flags-"+ext_name).click();

              console.log("ctrl + q pressed");
            },

            'Ctrl-F' : function(){
              editor.execCommand("find");
            },
            'Ctrl-H' : function(){
              editor.execCommand("replace");
            },
            'Ctrl-R' : function(){
              $("#listing-space").load("listing?session="+rands());
              load_page_result(1);
            }

      },

      colorpicker : {
            mode : 'edit',
            hideDelay: 0, 
            type: 'macos',
            onHide: function (color) {
                console.log('hide', color)
            }
        }

      });

    editor.on('blur' , () => {
        console.log('saved')
    })

    setTimeout(function(){
        editor.refresh();
    }, 100);

    editor.on('inputRead', function onChange(editor, input) {
      
      var filter = $("body").attr("path");
      var extention = filter.split(".");
          extention = extention[(extention.length - 1)];

       if (input.text[0] === '#' && extention == "css")

        editor.state.colorpicker.popup_color_picker();
     
       if (input.text[0] === ';' || input.text[0] === ' ' || input.text[0] === '#' ) { return; }
        
        CodeMirror.commands.autocomplete(editor, null, { completeSingle: false });
     
    });

    