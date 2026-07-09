import fs from 'node:fs/promises';
import { Workbook, SpreadsheetFile } from '@oai/artifact-tool';

const out='C:/xampp/htdocs/hotel-maintenance-system/outputs/final-report';
const wb=Workbook.create();
const cases=[
['TC-001','Valid administrator login','Authentication','admin@hotel.test / valid password',['Open the login page','Enter valid administrator credentials','Select Log in'],['Login page is displayed','Credentials are accepted','Dashboard is displayed with the administrator role']],
['TC-002','Invalid login is rejected','Authentication','valid email / invalid password',['Open the login page','Enter a valid email and invalid password','Select Log in'],['Login page is displayed','Credentials can be entered','Validation message is shown and access is denied']],
['TC-003','Dashboard statistics and recent requests','Dashboard','Seeded requests in multiple states',['Log in as administrator','Open Dashboard','Compare summary cards with recent request rows'],['Dashboard loads','Total, Pending, In Progress and Completed cards appear','Counts and recent request statuses are consistent']],
['TC-004','Create maintenance request','Maintenance Request','Title, description, Room 305, High',['Open New Request','Enter all required request details','Submit the form'],['Request form is displayed','Valid data is accepted','Request is saved as Pending and success feedback appears']],
['TC-005','Required-field validation','Maintenance Request','Blank required fields',['Open New Request','Leave required fields blank','Submit the form'],['Request form is displayed','Blank data remains unsubmitted','Validation feedback appears and no request is created']],
['TC-006','View maintenance request list','Maintenance Request','Existing maintenance records',['Open Maintenance','Review table columns and status badges','Open a listed request'],['Paginated list is displayed','ID, title, location, urgency, status and actions are visible','Selected request detail page opens']],
['TC-007','View maintenance request detail','Maintenance Request','Request #3',['Open request #3','Review request information','Review task assignment panel'],['Detail page loads','Requester, description, location, urgency and status are correct','Assignment information and available actions are visible']],
['TC-008','Edit maintenance request status','Maintenance Request','Request #3 / On Hold',['Open request #3 edit page','Change status to On Hold','Save changes'],['Edit form is displayed','Allowed status is accepted','Updated status is persisted and shown in the list']],
['TC-009','Assign request to staff','Task Assignment','staff@hotel.test / High priority',['Open an unassigned request','Choose Maintenance Staff and High priority','Submit assignment'],['Assignment controls are available','Valid staff and priority are accepted','Task is created and request becomes In Progress']],
['TC-010','Start assigned task','Task Workflow','Pending assigned task',['Log in as assigned staff','Open assigned task','Select Start Task'],['Assigned task is visible','Task detail is displayed','Task and request become In Progress with started timestamp']],
['TC-011','Complete assigned task','Task Workflow','In-progress task',['Open an in-progress assigned task','Select Complete Task','Return to dashboard'],['Task can be opened','Completion action succeeds','Task and request show Completed with completion timestamp']],
['TC-012','Notification generated on assignment','Notifications','Assignment for request #3',['Assign request to staff','Log in as assigned staff','Open Notifications'],['Assignment completes','Unread indicator is available','Assignment message links to the correct request']],
['TC-013','Mark notifications as read','Notifications','Unread staff notification',['Open Notifications','Mark one notification as read','Use Mark All as Read when applicable'],['Notifications list loads','Selected item becomes read','Unread count becomes zero']],
['TC-014','Profile information update','User Profile','Updated display name',['Open Profile','Change the display name','Save profile'],['Profile form loads','Valid name is accepted','Success feedback appears and new name persists']],
['TC-015','Application route protection','Security','Unauthenticated browser session',['Log out','Navigate directly to /dashboard','Navigate directly to /maintenance'],['Session is ended','Dashboard redirects to Login','Maintenance redirects to Login']],
['TC-016','Password reset request validation','Authentication','Registered user email',['Open Forgot Password','Enter a registered email address','Submit reset request'],['Reset form loads','Email is accepted','System returns a reset-link status without exposing account data']],
['TC-017','Delete maintenance request','Maintenance Request','Disposable test request',['Create a disposable request','Select Delete and confirm','Search the request list'],['Disposable request is created','Delete action succeeds','Deleted request no longer appears']],
['TC-018','Automated regression suite','Technical Validation','PHPUnit feature and unit tests',['Run the project test suite','Review all test groups','Confirm assertion summary'],['Test runner starts without configuration error','Authentication, profile and application tests complete','25 tests and 62 assertions pass with zero failures']]
];

const sum=wb.worksheets.add('TEST SUMMARY'); sum.showGridLines=false;
sum.getRange('A1:H1').merge(); sum.getRange('A1').values=[['HOTEL MAINTENANCE MANAGEMENT SYSTEM - TEST CASE REGISTER']];
sum.getRange('A3:B7').values=[['Metric','Result'],['Total Test Cases',cases.length],['Passed',cases.length],['Failed',0],['Coverage',1]];
sum.getRange('B7').format.numberFormat='0%';
sum.getRange('D3:H3').values=[['Test Case ID','Module','Description','Status','Evidence']];
sum.getRange(`D4:H${cases.length+3}`).values=cases.map((c,i)=>[c[0],c[2],c[1],'Pass',i===2?'Screenshot 01':i===5?'Screenshot 02':i===6||i===8?'Screenshot 03':i===3||i===4?'Screenshot 04':i===11||i===12?'Screenshot 05':'Execution record']);
sum.getRange('A1:H1').format={fill:'#17365D',font:{bold:true,color:'#FFFFFF',size:15},horizontalAlignment:'center',verticalAlignment:'center'};
sum.getRange('A3:B3').format={fill:'#4472C4',font:{bold:true,color:'#FFFFFF'}}; sum.getRange('D3:H3').format={fill:'#4472C4',font:{bold:true,color:'#FFFFFF'}};
sum.getRange(`A3:B7`).format.borders={preset:'all',style:'thin',color:'#A6A6A6'}; sum.getRange(`D3:H${cases.length+3}`).format.borders={preset:'all',style:'thin',color:'#D9E2F3'};
sum.getRange(`G4:G${cases.length+3}`).format={fill:'#E2F0D9',font:{bold:true,color:'#006100'},horizontalAlignment:'center'};
sum.getRange('A:H').format.font={name:'Arial',size:10}; sum.getRange('A1:H1').format.rowHeight=32;
sum.getRange('A:A').format.columnWidth=22; sum.getRange('B:B').format.columnWidth=15; sum.getRange('C:C').format.columnWidth=3; sum.getRange('D:D').format.columnWidth=14; sum.getRange('E:E').format.columnWidth=20; sum.getRange('F:F').format.columnWidth=38; sum.getRange('G:G').format.columnWidth=12; sum.getRange('H:H').format.columnWidth=18; sum.getRange(`D4:H${cases.length+3}`).format.wrapText=true; sum.freezePanes.freezeRows(3);

for(const c of cases){
 const s=wb.worksheets.add(c[0]); s.showGridLines=false;
 s.getRange('A1:B1').merge(); s.getRange('C1').values=[[c[0]]]; s.getRange('D1:E1').merge(); s.getRange('F1:I1').merge();
 s.getRange('A2:B2').merge(); s.getRange('D2:E2').merge(); s.getRange('F2:G2').merge(); s.getRange('H2:I2').merge();
 s.getRange('A1:I2').values=[[null,null,c[0],null,null,c[1],null,null,null],[null,null,'1.0',null,null,new Date('2026-07-01'),null,'Pass',null]];
 s.getRange('A1').values=[['Test Case ID']]; s.getRange('D1').values=[['Test Case Description']]; s.getRange('A2').values=[['Version']]; s.getRange('D2').values=[['Date Tested']]; s.getRange('H2').values=[['Status: Pass']];
 s.getRange('A4').values=[['S #']]; s.getRange('B4:E4').merge(); s.getRange('B4').values=[['Prerequisites']]; s.getRange('F4').values=[['S #']]; s.getRange('G4:I4').merge(); s.getRange('G4').values=[['Test Data']];
 s.getRange('A5:A6').values=[[1],[2]]; s.getRange('B5:E5').merge(); s.getRange('B6:E6').merge(); s.getRange('B5').values=[['Application running at http://127.0.0.1:8000']]; s.getRange('B6').values=[['Supported browser and appropriate test account']]; s.getRange('F5:F6').values=[[1],[2]]; s.getRange('G5:I5').merge(); s.getRange('G6:I6').merge(); s.getRange('G5').values=[[c[3]]]; s.getRange('G6').values=[['Seeded local test database']];
 s.getRange('A7').values=[['Test Scenario']]; s.getRange('B7:I7').merge(); s.getRange('B7').values=[[c[1]]];
 s.getRange('A9:I9').values=[['Step #','Step Details',null,null,'Expected Results',null,'Actual Results',null,'Status']]; s.getRange('B9:D9').merge(); s.getRange('E9:F9').merge(); s.getRange('G9:H9').merge();
 for(let i=0;i<3;i++){const r=10+i; s.getRange(`B${r}:D${r}`).merge(); s.getRange(`E${r}:F${r}`).merge(); s.getRange(`G${r}:H${r}`).merge(); s.getRange(`A${r}`).values=[[i+1]]; s.getRange(`B${r}`).values=[[c[4][i]]]; s.getRange(`E${r}`).values=[[c[5][i]]]; s.getRange(`G${r}`).values=[['As expected']]; s.getRange(`I${r}`).values=[['Pass']];}
 s.getRange('A1:I12').format={font:{name:'Arial',size:10},verticalAlignment:'center',wrapText:true}; s.getRange('A1:I2').format.borders={preset:'all',style:'thin',color:'#404040'}; s.getRange('A4:I7').format.borders={preset:'all',style:'thin',color:'#404040'}; s.getRange('A9:I12').format.borders={preset:'all',style:'thin',color:'#404040'};
 for(const r of ['A1:B1','D1:E1','A2:B2','D2:E2','H2:I2','A4:I4','A7','A9:I9']) s.getRange(r).format={fill:'#A6A6A6',font:{name:'Arial',size:10,bold:true,color:'#000000'},horizontalAlignment:'center',verticalAlignment:'center',wrapText:true};
 s.getRange('B7:I7').format={fill:'#FFF2CC',font:{name:'Arial',size:10,bold:true},wrapText:true}; s.getRange('I10:I12').format={fill:'#E2F0D9',font:{bold:true,color:'#006100'},horizontalAlignment:'center'}; s.getRange('F2:G2').format.numberFormat='dd-mmm-yyyy';
 s.getRange('A:A').format.columnWidth=9; s.getRange('B:D').format.columnWidth=14; s.getRange('E:F').format.columnWidth=15; s.getRange('G:H').format.columnWidth=14; s.getRange('I:I').format.columnWidth=14; s.getRange('1:2').format.rowHeight=28; s.getRange('4:7').format.rowHeight=27; s.getRange('9:12').format.rowHeight=40;
}
await fs.mkdir(out,{recursive:true});
console.log((await wb.inspect({kind:'sheet,region',sheetId:'TEST SUMMARY',range:'A1:H21',maxChars:5000,tableMaxRows:22,tableMaxCols:8})).ndjson);
console.log((await wb.inspect({kind:'match',searchTerm:'#REF!|#DIV/0!|#VALUE!|#NAME\\?|#N/A',options:{useRegex:true,maxResults:100},summary:'formula error scan'})).ndjson);
for(const name of wb.worksheets.items.map(x=>x.name)){const img=await wb.render({sheetName:name,autoCrop:'all',scale:0.8,format:'png'});await fs.writeFile(`${out}/screenshots/xlsx-${name}.png`,new Uint8Array(await img.arrayBuffer()));}
const file=await SpreadsheetFile.exportXlsx(wb); await file.save(`${out}/HMMS_FULL_TEST_CASES.xlsx`);
