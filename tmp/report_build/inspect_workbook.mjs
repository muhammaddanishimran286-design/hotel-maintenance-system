import fs from 'node:fs/promises';
import { FileBlob, SpreadsheetFile } from '@oai/artifact-tool';

const input = await FileBlob.load('C:/Users/user/Downloads/TEST CASE TEMPLATE (DCS-SAS).xlsx');
const workbook = await SpreadsheetFile.importXlsx(input);
console.log((await workbook.inspect({kind:'workbook,sheet,region',maxChars:12000,tableMaxRows:40,tableMaxCols:15})).ndjson);
await fs.mkdir('C:/xampp/htdocs/hotel-maintenance-system/tmp/report_build/xlsx_preview',{recursive:true});
for (const sheet of workbook.worksheets.items) {
  const img = await workbook.render({sheetName:sheet.name,autoCrop:'all',scale:1,format:'png'});
  await fs.writeFile(`C:/xampp/htdocs/hotel-maintenance-system/tmp/report_build/xlsx_preview/${sheet.name}.png`,new Uint8Array(await img.arrayBuffer()));
}
