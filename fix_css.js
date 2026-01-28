const fs = require('fs');
const path = require('path');

const BASE_FONT = 14;

// 命令行參數
const args = process.argv.slice(2);
const checkOnly = args.includes('--check') || args.includes('-c');
const scanMode = args.includes('--scan') || args.includes('-s');
const helpMode = args.includes('--help') || args.includes('-h');

function pxToRem(px) {
    const rem = px / BASE_FONT;
    return rem.toFixed(5).replace(/\.?0+$/, '');
}

function checkCssFile(filePath) {
    if (!fs.existsSync(filePath)) {
        console.log(`  ✗ 檔案不存在: ${filePath}`);
        return { exists: false };
    }

    const content = fs.readFileSync(filePath, 'utf8');
    const issues = [];

    // 檢查 line-height
    const lineHeightMatches = content.match(/line-height:\s*(\d+)px/g) || [];
    if (lineHeightMatches.length > 0) {
        issues.push({
            type: 'line-height',
            count: lineHeightMatches.length,
            examples: lineHeightMatches.slice(0, 3)
        });
    }

    // 檢查 max-width (排除 @media)
    const lines = content.split('\n');
    let maxWidthIssues = 0;
    let inMediaQuery = false;

    for (const line of lines) {
        if (line.includes('@media') && line.includes('max-width')) {
            inMediaQuery = true;
            continue;
        }
        if (inMediaQuery && line.includes('{')) {
            inMediaQuery = false;
        }
        if (!inMediaQuery && /max-width:\s*(\d+)px/.test(line)) {
            maxWidthIssues++;
        }
    }

    if (maxWidthIssues > 0) {
        issues.push({
            type: 'max-width',
            count: maxWidthIssues
        });
    }

    return { exists: true, issues };
}

function fixCssFile(filePath, dryRun = false) {
    console.log(`\n處理: ${path.basename(filePath)}`);

    if (!fs.existsSync(filePath)) {
        console.log(`  ✗ 檔案不存在`);
        return false;
    }

    let content = fs.readFileSync(filePath, 'utf8');
    const originalContent = content;

    let maxWidthCount = 0;
    let lineHeightCount = 0;

    // 修復 line-height
    content = content.replace(/line-height:(\s*)(\d+)px/g, (match, space, px) => {
        lineHeightCount++;
        return `line-height:${space}${pxToRem(parseInt(px))}rem`;
    });

    // 修復 max-width (但不包括 @media 中的)
    const lines = content.split('\n');
    const newLines = [];
    let inMediaQuery = false;

    for (const line of lines) {
        if (line.includes('@media') && line.includes('max-width')) {
            inMediaQuery = true;
            newLines.push(line);
            continue;
        }

        if (inMediaQuery && line.includes('{')) {
            inMediaQuery = false;
        }

        if (!inMediaQuery && /max-width:(\s*)(\d+)px/.test(line)) {
            newLines.push(line.replace(/max-width:(\s*)(\d+)px/g, (match, space, px) => {
                maxWidthCount++;
                return `max-width:${space}${pxToRem(parseInt(px))}rem`;
            }));
        } else {
            newLines.push(line);
        }
    }

    content = newLines.join('\n');

    if (content === originalContent) {
        console.log('  ✓ 無需修改');
        return true;
    }

    if (dryRun) {
        console.log('  ⚠ 發現問題 (檢查模式,未修改):');
        console.log(`    - max-width: ${maxWidthCount}`);
        console.log(`    - line-height: ${lineHeightCount}`);
        console.log(`    - 總計: ${maxWidthCount + lineHeightCount}`);
        return false;
    }

    fs.writeFileSync(filePath, content, 'utf8');
    console.log('  ✓ 修改完成');
    console.log(`    - max-width: ${maxWidthCount}`);
    console.log(`    - line-height: ${lineHeightCount}`);
    console.log(`    - 總計: ${maxWidthCount + lineHeightCount}`);
    return true;
}

function scanDirectory(dir, extensions = ['.css']) {
    const files = [];

    function scan(currentDir) {
        if (!fs.existsSync(currentDir)) return;

        const items = fs.readdirSync(currentDir);

        for (const item of items) {
            const fullPath = path.join(currentDir, item);
            const stat = fs.statSync(fullPath);

            if (stat.isDirectory()) {
                // 跳過 node_modules 和隱藏目錄
                if (!item.startsWith('.') && item !== 'node_modules') {
                    scan(fullPath);
                }
            } else if (stat.isFile()) {
                const ext = path.extname(item);
                if (extensions.includes(ext)) {
                    files.push(fullPath);
                }
            }
        }
    }

    scan(dir);
    return files;
}

function showHelp() {
    console.log(`
CSS WCAG 2.2 AAA 無障礙修復工具

用法:
  node fix_css.js [選項] [檔案...]

選項:
  -c, --check    只檢查檔案,不進行修改
  -s, --scan     掃描工作區中的所有 CSS 檔案
  -h, --help     顯示此幫助訊息

範例:
  # 修復預設檔案列表
  node fix_css.js

  # 只檢查檔案
  node fix_css.js --check

  # 掃描並修復工作區中的所有 CSS 檔案
  node fix_css.js --scan

  # 檢查工作區中的所有 CSS 檔案
  node fix_css.js --scan --check

  # 修復指定的檔案
  node fix_css.js file1.css file2.css

修改規則:
  - 基準字體: ${BASE_FONT}px
  - line-height: XXpx → X.XXXXXrem
  - max-width: XXpx → X.XXXXXrem (CSS 屬性,不包括 @media)
`);
}

// 主程式
if (helpMode) {
    showHelp();
    process.exit(0);
}

console.log('='.repeat(60));
console.log('CSS WCAG 2.2 AAA 無障礙修復工具');
if (checkOnly) {
    console.log('模式: 檢查模式 (不會修改檔案)');
}
console.log('='.repeat(60));

let files = [];

// 從命令行參數獲取檔案
const fileArgs = args.filter(arg => !arg.startsWith('-'));
if (fileArgs.length > 0) {
    files = fileArgs.map(f => path.resolve(f));
} else if (scanMode) {
    // 掃描模式
    const baseDir = process.cwd();
    console.log(`\n掃描目錄: ${baseDir}`);
    files = scanDirectory(baseDir);
    console.log(`找到 ${files.length} 個 CSS 檔案`);
} else {
    // 預設檔案列表
    const baseDir = 'c:\\Users\\tad\\tn\\UniServerZ\\www\\modules\\tadtools';
    files = [
        path.join(baseDir, 'bootstrap-table', 'bootstrap-table.css'),
        path.join(baseDir, 'bootstrap-table', 'bootstrap-table.min.css'),
        path.join(baseDir, 'bootstrap-table', 'themes', 'bulma', 'bootstrap-table-bulma.css'),
        path.join(baseDir, 'bootstrap-table', 'themes', 'foundation', 'bootstrap-table-foundation.css'),
        path.join(baseDir, 'bootstrap-table', 'themes', 'materialize', 'bootstrap-table-materialize.css'),
        path.join(baseDir, 'bootstrap-table', 'themes', 'semantic', 'bootstrap-table-semantic.css'),
    ];
}

let successCount = 0;
let issueCount = 0;

files.forEach((file, i) => {
    console.log(`\n[${i + 1}/${files.length}]`);
    const result = fixCssFile(file, checkOnly);
    if (checkOnly) {
        if (!result) issueCount++;
    } else {
        if (result) successCount++;
    }
});

console.log('\n' + '='.repeat(60));
if (checkOnly) {
    console.log(`✓ 檢查完成! 發現 ${issueCount} 個檔案需要修復`);
    if (issueCount > 0) {
        console.log('\n執行 node fix_css.js 來修復這些檔案');
    }
} else {
    console.log(`✓ 完成! 成功處理 ${successCount}/${files.length} 個檔案`);
}
console.log('='.repeat(60));
