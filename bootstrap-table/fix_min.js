const fs = require('fs');
let code = fs.readFileSync('bootstrap-table.min.js', 'utf8');

const r1 = `var tabindex=_this2.options.sortable&&column.sortable?' tabindex="0"':'';html.push(Utils.sprintf('<div class="th-inner %s"'+tabindex+'>',_this2.options.sortable&&column.sortable?"sortable".concat(columnHalign==='center'?' sortable-center':''," both"):''))`;
const regex1 = /html\.push\(Utils\.sprintf\('<div class=\"th-inner %s\">',_this2\.options\.sortable&&column\.sortable\?\"sortable\"\.concat\(columnHalign==='center'\?' sortable-center':'',\" both\"\):''\)\)/g;

let updated = code;
updated = updated.replace(regex1, r1);
const matched1 = code !== updated;
console.log("Regex 1 replaced? " + matched1);

let code2 = updated;
const regex2 = /this\.\$container\.off\(\"click\",\"\.th-inner\"\)\.on\(\"click\",\"\.th-inner\",\(function\s*\(\w\)\{\s*var\s*\$this=\$\(\w\.currentTarget\);/;
if(regex2.test(updated)){
    updated = updated.replace(regex2, (match) => {
        let eArg = match.match(/function\s*\((\w)\)/)[1];
        return `this.$container.off("click keydown",".th-inner").on("click keydown",".th-inner",(function(${eArg}){if(${eArg}.type==='keydown'&&${eArg}.keyCode!==13&&${eArg}.keyCode!==32)return;if(${eArg}.type==='keydown'&&${eArg}.keyCode===32)${eArg}.preventDefault();var $this=\$(${eArg}.currentTarget);`
    });
    console.log("Target 2 replaced.");
}

if (code !== updated) { fs.writeFileSync('bootstrap-table.min.js', updated); console.log("File saved."); }
else { console.log("No changes made."); }
