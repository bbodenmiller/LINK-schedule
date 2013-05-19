# Schedule for [Sound Transit LINK](http://www.soundtransit.org/Schedules/Central-Link-light-rail) #
Based on GTFS data.

[View schedule](http://bbodenmiller.github.io/LINK-schedule)

## Train Predictor Features ##
Train departing other direction
Train arriving my direction -> time between stops, etc. 

## Data Source ##

[King County GTFS Transit Data](http://metro.kingcounty.gov/GTFS/)

https://maps.googleapis.com/maps/api/directions/json?origin=47.463902,-122.287972&destination=47.611776,-122.335816&sensor=false&mode=transit&departure_time=1368870885&alternatives=true

## GTFS to SQLite ##

https://github.com/cbick/gtfs_SQL_importer

http://oegeo.wordpress.com/2011/08/17/salt-lake-city-gtfs-into-sqlite/

http://stackoverflow.com/questions/13407468/gettings-stops-associated-with-a-route-from-gtfs-data

http://graphserver.github.io/graphserver/

https://github.com/andrewblim/gtfs-sql


## Select all LINK stops
SELECT stop_id, stop_name, stop_lat, stop_lon FROM gtfs_stops WHERE stop_id IN (
	SELECT DISTINCT stop_id FROM gtfs_stop_times WHERE trip_id IN (
		SELECT trip_id FROM gtfs_trips WHERE route_id IN (
			SELECT route_id FROM gtfs_routes WHERE route_short_name = 'LINK')));

## All trips LINK makes
SELECT trip_id, trip_headsign FROM gtfs_trips WHERE route_id IN (
	SELECT route_id FROM gtfs_routes WHERE route_short_name = 'LINK');

## All trips from Tukwila station to downtown
SELECT gtfs_stop_times.stop_id AS stop_id, gtfs_stops.stop_name AS stop_name, service_id, gtfs_stop_times.arrival_time AS arrival_time, gtfs_stop_times.departure_time AS departure_time, route_trips.trip_headsign AS trip_headsign
FROM gtfs_stop_times, 
	(SELECT trip_id, service_id, trip_headsign, trip_short_name FROM gtfs_trips WHERE route_id IN (
		SELECT route_id FROM gtfs_routes WHERE route_short_name = 'LINK')
	) AS route_trips,
	gtfs_stops
WHERE gtfs_stop_times.trip_id = route_trips.trip_id AND gtfs_stop_times.stop_id = gtfs_stops.stop_id AND gtfs_stops.stop_id=99905 AND service_id='SUNDAY'
ORDER BY departure_time asc;

# todo
* calculate times based on frequencies.txt for weekdays
* add calendar_exceptions
* calculate when data set runs out
* notify when data is updated
